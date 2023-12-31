<?php

namespace App\Service;

use App\Entity\Trick;
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

        foreach ($trick->getPictures() as $picture) {
            if ($picture->getFile() === null) {
                $picture->setFileName($picture->getFileName());
            } else {
                $picture->setFileName($this->uploadPicture->upload($picture));
                $trick->getPictures()->first()->setFirstPicture(true);
            }
            $picture->setAlt($picture->getAlt());
            $this->manager->persist($picture);
        }

        foreach ($trick->getVideos() as $video) {
            $video->setUrl($video->getUrl());
            $this->manager->persist($video);
        }

        $this->manager->persist($trick);
        $this->manager->flush();
    }


}
