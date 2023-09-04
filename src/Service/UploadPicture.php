<?php

namespace App\Service;

use App\Entity\Interfaces\UploadEntityInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
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


    public function upload(UploadEntityInterface $picture): void
    {
        $file = $picture->getFile();
        $file->move($this->getDir($picture), $file->getClientOriginalName());
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


}
