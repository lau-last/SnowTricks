<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
//      Category
        $categoryGrab = new \App\Entity\Category();
        $categoryGrab->setLabel('Grab');
        $manager->persist($categoryGrab);


        $categoryRotation = new \App\Entity\Category();
        $categoryRotation->setLabel('Rotation');
        $manager->persist($categoryRotation);


        $categoryFlip = new \App\Entity\Category();
        $categoryFlip->setLabel('Flip');
        $manager->persist($categoryFlip);


        $categorySlide = new \App\Entity\Category();
        $categorySlide->setLabel('Slide');
        $manager->persist($categorySlide);


        $manager->flush();

        $this->addReference('category-0', $categoryGrab);
        $this->addReference('category-1', $categoryRotation);
        $this->addReference('category-2', $categoryFlip);
        $this->addReference('category-3', $categorySlide);

//        Tricks
        $trickData = [
            0 => [
                'name' => 'mute',
                'slug' => 'mute',
                'description' => 'saisie de la carre frontside de la planche entre les deux pieds avec la main avant.'
            ],
            1 => [
                'name' => 'sad',
                'slug' => 'sad',
                'description' => 'saisie de la carre backside de la planche, entre les deux pieds, avec la main avant.'
            ],
            2 => [
                'name' => 'indy',
                'slug' => 'indy',
                'description' => 'saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière.'
            ],
            3 => [
                'name' => 'stalefish',
                'slug' => 'stalefish',
                'description' => 'saisie de la carre backside de la planche entre les deux pieds avec la main arrière.'
            ],
            4 => [
                'name' => 'tail grab',
                'slug' => 'tail-grab',
                'description' => 'saisie de la partie arrière de la planche, avec la main arrière.'
            ],
            5 => [
                'name' => 'nose grab',
                'slug' => 'nose-grab',
                'description' => 'saisie de la partie avant de la planche, avec la main avant'
            ],
            6 => [
                'name' => 'japan',
                'slug' => 'japan',
                'description' => 'saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside'
            ],
            7 => [
                'name' => 'seat belt',
                'slug' => 'seat-belt',
                'description' => 'saisie du carre frontside à l\'arrière avec la main avant.'
            ],
            8 => [
                'name' => 'truck driver',
                'slug' => 'truck-driver',
                'description' => 'saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture)'
            ],
            9 => [
                'name' => '270',
                'slug' => '270',
                'description' => 'trois quarts de tours'
            ],
            10 => [
                'name' => '360',
                'slug' => '360',
                'description' => 'trois six pour un tour complet'
            ],
            11 => [
                'name' => '540',
                'slug' => '540',
                'description' => 'cinq quatre pour un tour et demi'
            ],
            12 => [
                'name' => '630',
                'slug' => '630',
                'description' => 'un tour trois quarts'
            ],
            13 => [
                'name' => '720',
                'slug' => '720',
                'description' => 'sept deux pour deux tours complets'
            ],
            14 => [
                'name' => '1080',
                'slug' => '1080',
                'description' => 'big foot pour trois tours'
            ],
            15 => [
                'name' => 'front flips',
                'slug' => 'front-flips',
                'description' => 'rotations en avant'
            ],
            16 => [
                'name' => 'back flips',
                'slug' => 'back-flips',
                'description' => 'rotations en arrière'
            ],
            17 => [
                'name' => 'Mac Twist',
                'slug' => 'Mac-Twist',
                'description' => 'flips agrémentés d\'une vrille'
            ],
            18 => [
                'name' => 'nose slide',
                'slug' => 'nose-slide',
                'description' => 'c\'est-à-dire slider avec l\'avant de la planche sur la barre'
            ],
            19 => [
                'name' => 'tail slide',
                'slug' => 'tail-slide',
                'description' => 'c\'est-à-dire slider avec l\'arrière de la planche sur la barre'
            ],
        ];

        for ($i = 0; $i < count($trickData); $i++) {
            $trick = new \App\Entity\Trick();
            $trick
                ->setName($trickData[$i]['name'])
                ->setSlug($trickData[$i]['slug'])
                ->setDescription($trickData[$i]['description'])
                ->setCreatedAt(new \DateTimeImmutable())
                ->setCategory($this->getReference('category-'.rand(0,3)));
            $this->addReference('trick-'.$i, $trick);
            $manager->persist($trick);
        }
        $manager->flush();
//        Users
        $userData = [
            0 => [
                'name' => 'laurent',
                'email' => 'laurent@gmail.com',
                'media' => 'laurent.jpeg'
            ],
            1 => [
                'name' => 'sandrine',
                'email' => 'sandrine@gmail.com',
                'media' => 'sandrine.jpeg'
            ],
            2 => [
                'name' => 'aurelie',
                'email' => 'aurelie@gmail.com',
                'media' => 'aurelie.jpeg'
            ]
        ];

        for ($i = 0; $i < count($userData); $i++) {
            $user = new \App\Entity\User();
            $user
                ->setName($userData[$i]['name'])
                ->setEmail($userData[$i]['email'])
                ->setMedia($userData[$i]['media'])
                ->setPassword('$2y$13$pGH91S7PI0dAgdwundiFS.PcFjn06Sy9vrkJvcCg.y7cI1IjqN/K2')
                ->setToken('token')
                ->setIsRegistered(true)
                ->setCreatedAt(new \DateTimeImmutable());
            $this->setReference('user-'.$i, $user);
            $manager->persist($user);
        }
        $manager->flush();

//        Comment
        for ($i = 0; $i < 20; $i++) {
            for ($i = 0; $i < 20; $i++) {
                $comment = new \App\Entity\Comment();
                $comment
                    ->setContent('Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression.')
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setTrick($this->getReference('trick-' . $i))
                    ->setUser($this->getReference('user-' . rand(0, 2)));
                $manager->persist($comment);
            }
        }

        $manager->flush();

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
