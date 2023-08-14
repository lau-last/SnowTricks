<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use MongoDB\Driver\Manager;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $categoryLabel = ['Grabs', 'Rotations', 'Flips', 'Slides'];
        Category::create($manager, $categoryLabel);

        $users = [
            'user1' => [
                'name' => 'Laurent La',
                'email' => 'laurent@gmail.com',
                'media' => 'laurent.jpg',
                'password' => '123',
                'token' => 'token',
            ],
            'user2' => [
                'name' => 'Aurélie La',
                'email' => 'aurelie@gmail.com',
                'media' => 'aurelie.jpg',
                'password' => '123',
                'token' => 'token',
            ],
            'user3' => [
                'name' => 'Sandrine La',
                'email' => 'sandrine@gmail.com',
                'media' => 'sandrine.jpg',
                'password' => '123',
                'token' => 'token',
            ]
        ];

    }


}
