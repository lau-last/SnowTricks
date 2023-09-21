<?php

namespace App\Service;

use App\Entity\Trick;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class FirstPicture
{

    private EntityManagerInterface $manager;


    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }


    public function makeAll(): void
    {
        $allTricks = $this->manager->getRepository(Trick::class)->findAll();
        foreach ($allTricks as $trick){
            $this->extracted($trick);
        }
    }

    public function makeTrick(Trick $trick): void
    {
        $this->extracted($trick);
    }


    /**
     * @param mixed $trick
     * @return void
     */
    public function extracted(mixed $trick): void
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