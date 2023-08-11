<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Category
{
    public static function create(ObjectManager $manager, array $categoryLabel): void
    {

        for ($i = 0; $i < count($categoryLabel); $i++){
            $category = new \App\Entity\Category();
            $category->setLabel($categoryLabel[$i]);

            $manager->persist($category);
        }

    }
}
