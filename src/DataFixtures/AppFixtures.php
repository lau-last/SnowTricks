<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Trick;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
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

        $categories = $manager->getRepository(Category::class)->findAll();

        for ($a = 0; $a < 2; $a++) {
            for ($i = 0; $i < 20; $i++) {
                $trick = new \App\Entity\Trick();
                $trick
                    ->setName($faker->unique()->name)
                    ->setSlug($faker->unique()->slug)
                    ->setDescription($faker->text())
                    ->setCategory($faker->randomElement($categories));
                $manager->persist($trick);
            }
        }

        $manager->flush();

        $tricks = $manager->getRepository(Trick::class)->findAll();

        $user = new \App\Entity\User();
        $user
            ->setUsername('laurent')
            ->setEmail($faker->unique()->email)
            ->setMedia('default.png')
            ->setPassword('$2y$13$pGH91S7PI0dAgdwundiFS.PcFjn06Sy9vrkJvcCg.y7cI1IjqN/K2')
            ->setActive(true)
            ->setExpirationDate(strtotime('now'));
        $manager->persist($user);

        $manager->flush();

        $users = $manager->getRepository(User::class)->findAll();

        for ($i = 0; $i < 500; $i++) {
            $comment = new \App\Entity\Comment();
            $comment
                ->setContent($faker->text)
                ->setTrick($faker->randomElement($tricks))
                ->setUser($faker->randomElement($users));
            $manager->persist($comment);
        }

        $manager->flush();

        for ($a = 0; $a < 3; $a++) {
            for ($i = 0; $i < 20; $i++) {
                $picture = new \App\Entity\TrickPicture();
                $picture
                    ->setFileName('trick-' . $i . '.jpg')
                    ->setAlt('trick-' . $i)
                    ->setTrick($faker->randomElement($tricks));
                $manager->persist($picture);
            }
        }

        $manager->flush();


        for ($a = 0; $a < 3; $a++) {
            for ($i = 0; $i < 20; $i++) {
                $video = new \App\Entity\TrickVideo();
                $video
                    ->setUrl('https://www.dailymotion.com/embed/video/xxxu60')
                    ->setTrick($faker->randomElement($tricks));
                $manager->persist($video);
            }
        }

        $manager->flush();
    }


}
