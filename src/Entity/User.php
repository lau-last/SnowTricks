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
#[UniqueEntity('email', message: 'The email you provided is already in use!')]
#[UniqueEntity('username', message: 'The name you specified is already in use!')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 80, unique: true)]
    #[Assert\Length(
        min: 3,
        max: 80,
        minMessage: 'Your name must be at least {{ limit }} characters.',
        maxMessage: 'Your name cannot be more than {{ limit }} characters.',
    )]
    #[Assert\NotNull(message: 'You must enter a name')]
    private ?string $username = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    #[Assert\NotNull(message: 'You must enter an email')]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull(message: 'You must enter a profile photo')]
    private ?string $media = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
        message: 'Your password must contain at least 8 characters, an uppercase letter, a lowercase letter and a special character.',
    )]
    #[Assert\NotNull(message: 'You must enter a password')]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $hashToken = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\Column]
    private bool $active = false;

    #[ORM\Column]
    private ?int $expirationDate = null;


    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getUsername(): ?string
    {
        return $this->username;
    }


    public function setUsername(?string $username): User
    {
        $this->username = $username;
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


    public function getHashToken(): ?string
    {
        return $this->hashToken;
    }


    public function setHashToken(?string $hashToken): User
    {
        $this->hashToken = $hashToken;
        return $this;
    }


    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }


    public function setCreatedAt(\DateTimeInterface $createdAt): static
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


    public function isActive(): bool
    {
        return $this->active;
    }


    public function setActive(bool $active): User
    {
        $this->active = $active;
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


    public function getExpirationDate(): ?int
    {
        return $this->expirationDate;
    }


    public function setExpirationDate(?int $expirationDate): User
    {
        $this->expirationDate = $expirationDate;
        return $this;
    }


}
