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
#[UniqueEntity('name', message: 'Le nom que vous avez indiqué est déjà utilisé !')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    #[Assert\EqualTo(propertyPath: 'password', message: 'Vous n\'avez pas tapez le même mot de passe.')]
    public ?string $confirm_password = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 80, unique: true)]
    #[Assert\Length(
        min: 3,
        max: 80,
        minMessage: 'Votre nom doit faire au moins {{ limit }} caractères.',
        maxMessage: 'Votre nom ne peut pas faire plus de {{ limit }} caractères.',
    )]
    #[Assert\NotNull(message: 'Vous devez entrez un nom')]
    private ?string $name = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\Email(
        message: 'L\'email {{ value }} n\'est pas un email valide.',
    )]
    #[Assert\NotNull(message: 'Vous devez entrez un email')]
    private ?string $email = null;

    #[ORM\Column(length: 80)]
    #[Assert\NotNull(message: 'Vous devez entrez une photo de profil')]
    private ?string $media = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
        message: 'Votre mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un caractère spécial.',
    )]
    #[Assert\NotNull(message: 'Vous devez entrez un mot de passe')]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $token = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\Column]
    private ?bool $isRegistered;


    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->isRegistered = false;
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


    public function getEmail(): ?string
    {
        return $this->email;
    }


    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }


}
