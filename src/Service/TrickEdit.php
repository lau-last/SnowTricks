<?php

namespace App\Service;

use App\Entity\Trick;
use App\Entity\TrickPicture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class TrickEdit
{

    private EntityManagerInterface $manager;

    private SluggerInterface $slugger;

    private UploadPicture $uploadPicture;


    public function __construct(EntityManagerInterface $manager, SluggerInterface $slugger, UploadPicture $uploadPicture)
    {
        $this->manager = $manager;
        $this->slugger = $slugger;
        $this->uploadPicture = $uploadPicture;
    }


    public function edit(Trick $trick, bool $option = false): void
    {
        $trick
            ->setName($trick->getName())
            ->setSlug($this->slugger->slug($trick->getName()))
            ->setDescription($trick->getDescription())
            ->setCategory($trick->getCategory());

        if ($option === true) {
            $trick->setUpdatedAt(new \DateTime());
        }

        $setDefaultFirst = true;

        /** @var TrickPicture $picture */
        foreach ($trick->getPictures() as $picture) {
            if($picture->isFirstPicture()){
                $setDefaultFirst = false;
            }
            if ($picture->getFile() === null){
                continue;
            }
            $picture->setFileName($this->uploadPicture->upload($picture));
            $picture->setAlt($picture->getAlt());
            $this->manager->persist($picture);
        }

        if($setDefaultFirst) {
            $trick->getPictures()->get(0)->setFirstPicture(true);
        }

        foreach ($trick->getVideos() as $video) {
            $video->setUrl($video->getUrl());
        }

        $this->manager->persist($trick);
        $this->manager->flush();
    }


}