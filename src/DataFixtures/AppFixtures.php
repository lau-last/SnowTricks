<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Trick;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 5; $i++) {
            $category = new Category();
            $category
                ->setLabel($faker->unique()->title);
            $manager->persist($category);
        }
        $manager->flush();


        for ($i = 0; $i < 20; $i++) {
            $trick = new \App\Entity\Trick();
            $trick
                ->setName($faker->unique()->name)
                ->setSlug($faker->unique()->slug)
                ->setDescription($faker->text())
                ->setCategory();
            $manager->persist($trick);
        }
        $manager->flush();

        for ($i = 0; $i < 1; $i++) {
            $user = new \App\Entity\User();
            $user
                ->setUsername('laurent')
                ->setEmail($faker->unique()->email)
                ->setMedia('default.png')
                ->setPassword('$2y$13$pGH91S7PI0dAgdwundiFS.PcFjn06Sy9vrkJvcCg.y7cI1IjqN/K2')
                ->setActive(true);
            $manager->persist($user);
        }

        $manager->flush();


            for ($i = 0; $i < 500; $i++) {
                $comment = new \App\Entity\Comment();
                $comment
                    ->setContent($faker->text)
                    ->setTrick($this->getReference(Trick::class))
                    ->setUser($this->getReference(User::class));
                $manager->persist($comment);
            }

        $manager->flush();

            return;

//        Picture
        for ($a = 0; $a < 3; $a++) {
            for ($i = 0; $i < 20; $i++) {
                $picture = new \App\Entity\TrickPicture();
                $picture
                    ->setFileName('trick-' . $i . '.jpg')
                    ->setAlt('trick-' . $i)
                    ->setTrick($this->getReference('trick-' . $i));
                $manager->persist($picture);
            }
        }

        $manager->flush();

//        TrickVideo
        for ($a = 0; $a < 3; $a++) {
            for ($i = 0; $i < 20; $i++) {
                $video = new \App\Entity\TrickVideo();
                $video
                    ->setUrl('https://www.dailymotion.com/embed/video/xxxu60')
                    ->setTrick($this->getReference('trick-' . $i));
                $manager->persist($video);
            }
        }

        $manager->flush();
    }


}
