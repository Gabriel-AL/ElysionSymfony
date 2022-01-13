<?php

namespace App\Entity;

use App\Repository\PlayedCharacterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlayedCharacterRepository::class)
 */
class PlayedCharacter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=RP::class, mappedBy="involvedCharacters")
     */
    private $rps;

    /**
     * @ORM\OneToOne(targetEntity=Inventory::class, mappedBy="relatedCharacter", cascade={"persist", "remove"})
     */
    private $inventory;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="playedcharacters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $account;

    /**
     * @ORM\OneToMany(targetEntity=RPPost::class, mappedBy="poster")
     */
    private $rPPosts;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    public function __construct()
    {
        $this->rps = new ArrayCollection();
        $this->rPPosts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|RP[]
     */
    public function getRps(): Collection
    {
        return $this->rps;
    }

    public function addRp(RP $rp): self
    {
        if (!$this->rps->contains($rp)) {
            $this->rps[] = $rp;
            $rp->addInvolvedCharacter($this);
        }

        return $this;
    }

    public function removeRp(RP $rp): self
    {
        if ($this->rps->removeElement($rp)) {
            $rp->removeInvolvedCharacter($this);
        }

        return $this;
    }

    public function getInventory(): ?Inventory
    {
        return $this->inventory;
    }

    public function setInventory(Inventory $inventory): self
    {
        // set the owning side of the relation if necessary
        if ($inventory->getRelatedCharacter() !== $this) {
            $inventory->setRelatedCharacter($this);
        }

        $this->inventory = $inventory;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    /**
     * @ORM\PrePersist
     */
    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @return Collection|RPPost[]
     */
    public function getRPPosts(): Collection
    {
        return $this->rPPosts;
    }

    public function addRPPost(RPPost $rPPost): self
    {
        if (!$this->rPPosts->contains($rPPost)) {
            $this->rPPosts[] = $rPPost;
            $rPPost->setPoster($this);
        }

        return $this;
    }

    public function removeRPPost(RPPost $rPPost): self
    {
        if ($this->rPPosts->removeElement($rPPost)) {
            // set the owning side to null (unless already changed)
            if ($rPPost->getPoster() === $this) {
                $rPPost->setPoster(null);
            }
        }

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function __toString()
    {
        return $this->firstname." ".$this->lastname;
    }
}
