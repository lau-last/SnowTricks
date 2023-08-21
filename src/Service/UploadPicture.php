<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadPicture
{

    public function add(): void
    {
        $pictureName = md5(uniqid(rand(), true)).$_FILES['profileImage']['name'];

    }


}
