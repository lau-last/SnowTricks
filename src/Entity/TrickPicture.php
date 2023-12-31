<?php

namespace App\Entity;

use App\Entity\Interfaces\UploadEntityInterface;
use App\Repository\TrickPictureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TrickPictureRepository::class)]
class TrickPicture implements UploadEntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull(message: 'You must enter the name of the figure')]
    private ?string $fileName = null;


    #[ORM\Column(length: 255)]
    #[Assert\NotNull(message: 'You must describe the photo')]
    private ?string $alt = null;

    #[ORM\Column]
    private bool $firstPicture = false;

    #[ORM\ManyToOne(inversedBy: 'pictures')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'cascade')]
    private ?Trick $trick = null;

    #[Assert\File(
        maxSize: '10M',
        maxSizeMessage: 'The image is too large, the maximum size is {{ limit }} mb',
        extensions: ['jpg', 'jpeg', 'png', 'webp'],
        extensionsMessage: 'Wrong image format. Format accepted: jpg, jpeg, png, webp.',
    )]
    //    #[Assert\NotNull(message: 'Vous devez entrez une photo')]
    private ?UploadedFile $file = null;


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getFileName(): ?string
    {
        return $this->fileName;
    }


    public function setFileName(string $fileName): static
    {
        $this->fileName = $fileName;

        return $this;
    }


    public function getAlt(): ?string
    {
        return $this->alt;
    }


    public function setAlt(string $alt): static
    {
        $this->alt = $alt;

        return $this;
    }


    public function getTrick(): ?Trick
    {
        return $this->trick;
    }


    public function setTrick(?Trick $trick): static
    {
        $this->trick = $trick;

        return $this;
    }


    /**
     * @return UploadedFile|null
     */
    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }


    /**
     * @param UploadedFile|null $file
     * @return self
     */
    public function setFile(?UploadedFile $file): self
    {
        $this->file = $file;
        if ($file instanceof UploadedFile) {
            $this->setFileName($file->getClientOriginalName());
        }
        return $this;
    }


    public function isFirstPicture(): bool
    {
        return $this->firstPicture;
    }


    public function setFirstPicture(bool $firstPicture): self
    {
        $this->firstPicture = $firstPicture;
        return $this;
    }


}
