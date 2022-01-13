<?php

namespace App\Entity;

use App\Repository\InventoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InventoryRepository::class)
 */
class Inventory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=PlayedCharacter::class, inversedBy="inventory", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $relatedCharacter;

    /**
     * @ORM\ManyToMany(targetEntity=Item::class)
     */
    private $possessions;

    public function __construct()
    {
        $this->possessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRelatedCharacter(): ?PlayedCharacter
    {
        return $this->relatedCharacter;
    }

    public function setRelatedCharacter(PlayedCharacter $relatedCharacter): self
    {
        $this->relatedCharacter = $relatedCharacter;

        return $this;
    }

    /**
     * @return Collection|Item[]
     */
    public function getPossessions(): Collection
    {
        return $this->possessions;
    }

    public function addPossession(Item $possession): self
    {
        if (!$this->possessions->contains($possession)) {
            $this->possessions[] = $possession;
        }

        return $this;
    }

    public function removePossession(Item $possession): self
    {
        $this->possessions->removeElement($possession);

        return $this;
    }
}
