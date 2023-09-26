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

//        $faker = \Faker\Factory::create();
//
//        for ($i = 0; $i < 5; $i++) {
//            $category = new Category();
//            $category
//                ->setLabel($faker->unique()->title);
//            $manager->persist($category);
//        }
//        $manager->flush();
//
//        $categories = $manager->getRepository(Category::class)->findAll();
//
//        for ($a = 0; $a < 2; $a++) {
//            for ($i = 0; $i < 20; $i++) {
//                $trick = new \App\Entity\Trick();
//                $trick
//                    ->setName($faker->unique()->name)
//                    ->setSlug($faker->unique()->slug)
//                    ->setDescription($faker->text())
//                    ->setCategory($faker->randomElement($categories));
//                $manager->persist($trick);
//            }
//        }
//
//        $manager->flush();
//
//        $tricks = $manager->getRepository(Trick::class)->findAll();
//
//        $user = new \App\Entity\User();
//        $user
//            ->setUsername('laurent')
//            ->setEmail($faker->unique()->email)
//            ->setMedia('default.png')
//            ->setPassword('$2y$13$pGH91S7PI0dAgdwundiFS.PcFjn06Sy9vrkJvcCg.y7cI1IjqN/K2')
//            ->setActive(true)
//            ->setExpirationDate(strtotime('now'));
//        $manager->persist($user);
//
//        $manager->flush();
//
//        $users = $manager->getRepository(User::class)->findAll();
//
//        for ($i = 0; $i < 500; $i++) {
//            $comment = new \App\Entity\Comment();
//            $comment
//                ->setContent($faker->text)
//                ->setTrick($faker->randomElement($tricks))
//                ->setUser($faker->randomElement($users));
//            $manager->persist($comment);
//        }
//
//        $manager->flush();
//
//        for ($a = 0; $a < 3; $a++) {
//            for ($i = 0; $i < 20; $i++) {
//                $picture = new \App\Entity\TrickPicture();
//                $picture
//                    ->setFileName('trick-' . $i . '.jpg')
//                    ->setAlt('trick-' . $i)
//                    ->setTrick($faker->randomElement($tricks));
//                $manager->persist($picture);
//            }
//        }
//
//        $manager->flush();
//
//
//        for ($a = 0; $a < 3; $a++) {
//            for ($i = 0; $i < 20; $i++) {
//                $video = new \App\Entity\TrickVideo();
//                $video
//                    ->setUrl('https://www.dailymotion.com/video/xxxu60')
//                    ->setTrick($faker->randomElement($tricks));
//                $manager->persist($video);
//            }
//        }
//
//        $manager->flush();

        $snowText =
            'Snowboarding is a sport filled with impressive and creative tricks. Among the most iconic are 
        the jumps. The "ollie" serves as the foundation for many tricks, where the rider pops the board by pressing on 
        the tail. The "360" involves a full rotation in the air, while the "backflip" is a daring backward somersault 
        that demands both courage and technique. "Grinding" is sliding along metal rails or ramps, and the "method air" 
        is an elegant aerial grab. Each rider develops their unique style, combining these tricks to create one-of-a-kind 
        sequences, offering an incredible show on the snow-covered slopes. Snowboarding is more than just a winter 
        sport; it\'s an artistic form of expression that constantly pushes the boundaries of creativity.';


        $user = new User();
        $user
            ->setUsername('laurent')
            ->setEmail('laurent@gmail.com')
            ->setMedia('default.png')
            ->setPassword('$2y$13$pGH91S7PI0dAgdwundiFS.PcFjn06Sy9vrkJvcCg.y7cI1IjqN/K2')
            ->setActive(true)
            ->setExpirationDate(strtotime('now'));
        $manager->persist($user);

        $categoryGrabs = new Category();
        $categoryGrabs->setLabel('grabs');
        $manager->persist($categoryGrabs);

        $grabsName = ['mute', 'sad', 'indy', 'stalefish', 'tail grab', 'nose grab', 'japan', 'seat belt', 'truck driver'];
        $grabsSlug = ['mute', 'sad', 'indy', 'stalefish', 'tail-grab', 'nose-grab', 'japan', 'seat-belt', 'truck-driver'];
        $grabsDescription = [
            'Frontside edge grab between the two feet with the front hand.',
            'Backside edge grab between the two feet with the front hand.',
            'Frontside edge grab between the two feet with the rear hand.',
            'Backside edge grab between the two feet with the rear hand.',
            'Grabbing the rear of the board with the rear hand.',
            'Grabbing the front of the board with the front hand.',
            'Grabbing the front of the board with the front hand, on the frontside edge.',
            'Grabbing the frontside edge at the back with the front hand.',
            'Grabbing both the front and back edges with each hand (like holding a car steering wheel).'
        ];

        for ($i = 0; $i < count($grabsName); $i++) {
            $trickGrabs = new Trick();
            $trickGrabs
                ->setName($grabsName[$i])
                ->setSlug($grabsSlug[$i])
                ->setDescription($grabsDescription[$i] . $snowText)
                ->setCategory($categoryGrabs);
            $manager->persist($trickGrabs);
        }

        $categoryRotations = new Category();
        $categoryRotations->setLabel('rotations');
        $manager->persist($categoryRotations);

        $rotationsName = ['90', '180', '270', '360', '450', '540', '630', '810', '900', '1080'];
        $rotationDescription = [
            'A simple quarter turn.',
            'Refers to a half-turn, which is 180 degrees of rotation.',
            'Three-quarters of a turn.',
            'Three sixes for a complete turn.',
            'One and a quarter turns.',
            'Five-quarters for a turn and a half.',
            'One and three-quarters turns.',
            'Two and a quarter turns.',
            'Two and a half turns.',
            'Big foot for three turns.'
        ];

        for ($i = 0; $i < count($rotationsName); $i++) {
            $trickRotations = new Trick();
            $trickRotations
                ->setName($rotationsName[$i])
                ->setSlug($rotationsName[$i])
                ->setDescription($rotationDescription[$i] . $snowText)
                ->setCategory($categoryRotations);
            $manager->persist($trickRotations);
        }

        $categoryFlips = new Category();
        $categoryFlips->setLabel('flips');
        $manager->persist($categoryFlips);

        $flipsName = ['mac twist', 'hakon flip'];
        $flipsSlug = ['mac-twist', 'hakon-flip'];

        for ($i = 0; $i < count($flipsName); $i++) {
            $trickFlips = new Trick();
            $trickFlips
                ->setName($flipsName[$i])
                ->setSlug($flipsSlug[$i])
                ->setDescription($snowText)
                ->setCategory($categoryFlips);
            $manager->persist($trickFlips);
        }

        $categoryOffAxis = new Category();
        $categoryOffAxis->setLabel('off-axis rotations');
        $manager->persist($categoryOffAxis);

        $offAxisName = ['corkscrew','rodeo','misty'];
        $offAxisSlug = [];

        $categorySlides = new Category();
        $categorySlides->setLabel('slides');
        $manager->persist($categorySlides);

        $categoryOneFoot = new Category();
        $categoryOneFoot->setLabel('one foot tricks');
        $manager->persist($categoryOneFoot);

        $categoryOldSchool = new Category();
        $categoryOldSchool->setLabel('old school');
        $manager->persist($categoryOldSchool);

        $manager->flush();

    }


}
