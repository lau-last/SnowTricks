<?php

namespace App\Service;

use App\Entity\Trick;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;

class FirstPicture
{

    private EntityManagerInterface $manager;


    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }


    public function makeFirst(Trick $trick): void
    {
        $first = true;
        $pictures = $trick->getPictures();
        foreach ($pictures as $picture) {
            if ($picture->isFirstPicture() === true) {
                $first = false;
            }
            if (!empty($picture) && $first === true) {
                $trick->getPictures()->get(0)->setFirstPicture(true);
            }

        }
        $this->manager->persist($trick);
        $this->manager->flush();
    }


}