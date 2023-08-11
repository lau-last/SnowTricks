<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class User
{

    public static function create(ObjectManager $manager, array $users): void
    {
        for ($i = 0; $i < count($users); $i++){
            $user = new \App\Entity\User();
            $user
                ->setName($users[$i]['name'])
                ->setEmail($users[$i]['email'])
                ->setMedia($users[$i]['media'])
                ->setPassword($users[$i]['password'])
                ->setToken($users[$i]['token'])
                ->setCreatedAt(new \DateTimeImmutable());
//            $category->setLabel($users[$i]);

            $manager->persist($user);
        }
    }


}
