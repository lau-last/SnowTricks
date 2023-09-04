<?php

namespace App\Service;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadUserProfile
{

    private string $newFilename;


    public function upload(FormInterface $form, string $inputName, SluggerInterface $slugger, string $fileDirectory): void
    {
        $file = $form->get($inputName)->getData();
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugger->slug($originalFileName);
        $this->newFilename = $safeFilename . '-' . md5(uniqid(rand(), true)) . '.' . $file->guessExtension();
        $file->move($fileDirectory, $this->newFilename);
    }


    /**
     * @return string
     */
    public function getNewFilename(): string
    {
        return $this->newFilename;
    }


}