<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
class TrickVideo
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\AtLeastOneOf([
        new Assert\Regex('/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube(-nocookie)?\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|live\/|v\/)?)([\w\-]+)(\S+)?$/'),
        new Assert\Regex('/^.+dailymotion.com\/(video|hub)\/([^_]+)[^#]*(#video=([^_&]+))?/'),
    ],
        message: 'The video URL is invalid, please insert the URL of a Youtube or Dailymotion video.',
        includeInternalMessages: false
    )]
    #[Assert\NotNull(message: 'You must enter a URL')]
    private ?string $url = null;

    #[ORM\ManyToOne(inversedBy: 'videos')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'cascade')]
    private ?Trick $trick = null;


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getUrlEmbed(): ?string
    {
        if (str_contains($this->getUrl(), 'www.youtube.com')) {
            return str_replace('watch?v=', 'embed/', $this->getUrl());
        }
        if (str_contains($this->getUrl(), 'www.dailymotion.com')) {
            return str_replace('www.dailymotion.com/', 'www.dailymotion.com/embed/', $this->getUrl());
        }
        return 'null';
    }


    public function getUrl(): ?string
    {
        return $this->url;
    }


    public function setUrl(string $url): static
    {
        $this->url = $url;

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


}
