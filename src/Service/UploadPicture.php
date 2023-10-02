<?php

namespace App\Service;

use App\Entity\Interfaces\UploadEntityInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadPicture
{

    private array $config;

    private SluggerInterface $slugger;


    public function __construct(ParameterBagInterface $bag, SluggerInterface $slugger)
    {
        $this->config = $bag->get('upload_service');
        $this->slugger = $slugger;
    }



    public function upload(UploadEntityInterface $picture): string
    {
        $file = $picture->getFile();
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFileName);
        $newFilename = $safeFilename . '-' . md5(uniqid(rand(), true)) . '.' . $file->guessExtension();
        $file->move($this->getDir($picture), $newFilename);
        return $newFilename;
    }


    public function uploadProfile(FormInterface $form, string $inputName, string $fileDirectory): string
    {
        $file = $form->get($inputName)->getData();
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFileName);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
        $file->move($fileDirectory, $newFilename);
        return $newFilename;
    }


    public function getFile(UploadEntityInterface $picture): File
    {
        return new File($this->getAbsoluteFileName($picture));
    }


    public function getAbsoluteFileName(UploadEntityInterface $picture): string
    {
        return $this->getDir($picture) . DIRECTORY_SEPARATOR . $picture->getFileName();
    }


    private function getDir(UploadEntityInterface $picture): string
    {
        $uploadDir = $this->config['upload_destination'];
        $mappings = $this->config['mappings'];

        if (isset($mappings[get_class($picture)])) {
            return $uploadDir . DIRECTORY_SEPARATOR . $mappings[get_class($picture)];
        }

        throw new \InvalidArgumentException("no mapping for " . get_class($picture));
    }

    public function delete(UploadEntityInterface $picture): void
    {
        $dir = $this->getDir($picture);
        $fileName = $picture->getFileName();
        unlink($dir . DIRECTORY_SEPARATOR . $fileName);
    }


}
