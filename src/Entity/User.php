<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('email', message: 'L\'email que vous avez indiqué est déjà utilisé !')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 80, unique: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 80)]
    private ?string $media = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[Assert\EqualTo(propertyPath: 'password', message: 'Vous n\'avez pas tapez le même mot de passe.')]
    public ?string $confirm_password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $token = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\Column]
    private ?bool $isRegistered = null;


    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getName(): ?string
    {
        return $this->name;
    }


    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }


    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }


    public function getMedia(): ?string
    {
        return $this->media;
    }


    public function setMedia(string $media): static
    {
        $this->media = $media;

        return $this;
    }


    public function getPassword(): ?string
    {
        return $this->password;
    }


    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }


    public function getToken(): ?string
    {
        return $this->token;
    }


    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }


    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }


    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }


    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }


    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setUser($this);
        }

        return $this;
    }


    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }


    public function isIsRegistered(): ?bool
    {
        return $this->isRegistered;
    }


    public function setIsRegistered(bool $isRegistered): static
    {
        $this->isRegistered = $isRegistered;

        return $this;
    }


    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }


    /**
     * @return void
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }


    /**
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return $this->getEmail();
    }


}
