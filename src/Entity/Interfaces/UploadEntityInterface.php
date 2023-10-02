<?php

namespace App\Entity\Interfaces;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UploadEntityInterface
{
    public function getFileName(): ?string;
    public function getFile(): ?UploadedFile;

}
