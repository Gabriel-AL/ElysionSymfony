<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AccountRepository::class)
 */
class Account implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 8,
     *      max = 180,
     *      minMessage = "Le mot de passe doit contenir au moins {{ limit }} caractères",
     *      maxMessage = "Le mot de passe doit contenir moins de {{ limit }} caractères"
     * )
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @Assert\NotBlank(message="Veuillez saisir un mot de passe")
     * @Assert\Regex(
     *      pattern="/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,180}$/",
     *      message="Votre mot de passe doit contenir entre 8 et 180 caractères, un symbole, et un chiffre"
     * )
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=PlayedCharacter::class, mappedBy="account", orphanRemoval=true)
     */
    private $playedcharacters;

    /**
     * @ORM\OneToMany(targetEntity=Notification::class, mappedBy="toAccount", orphanRemoval=true)
     */
    private $notifications;

    public function __construct()
    {
        $this->playedcharacters = new ArrayCollection();
        $this->notifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|PlayedCharacter[]
     */
    public function getPlayedCharacters(): Collection
    {
        return $this->playedcharacters;
    }

    public function addPlayedCharacter(PlayedCharacter $playedcharacter): self
    {
        if (!$this->playedcharacters->contains($playedcharacter)) {
            $this->playedcharacters[] = $playedcharacter;
            $playedcharacter->setAccount($this);
        }

        return $this;
    }

    public function removePlayedCharacter(PlayedCharacter $playedcharacter): self
    {
        if ($this->playedcharacters->removeElement($playedcharacter)) {
            // set the owning side to null (unless already changed)
            if ($playedcharacter->getAccount() === $this) {
                $playedcharacter->setAccount(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Notification[]
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setToAccount($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getToAccount() === $this) {
                $notification->setToAccount(null);
            }
        }

        return $this;
    }

}
