<?php

namespace App\Service;

use App\Entity\Trick;
use Doctrine\ORM\EntityManagerInterface;

class FirstPicture
{

    private EntityManagerInterface $manager;


    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }


    public function make(Trick $trick): void
    {
        $first = true;
        $collectionPicture = $trick->getPictures();
        foreach ($collectionPicture as $picture) {
            if (empty($picture)) {
                continue;
            }
            if ($picture->isFirstPicture()) {
                $first = false;
            }
            if ($first) {
                $trick->getPictures()->get(0)->setFirstPicture(true);
            }
            $this->manager->persist($trick);
        }
        $this->manager->flush();
    }


}