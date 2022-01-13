<?php

namespace App\Entity;

use App\Repository\PlacesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=PlacesRepository::class)
 */
class Places
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=RP::class, mappedBy="place")
     */
    private $rps;

    /**
     * @ORM\ManyToOne(targetEntity=Places::class, inversedBy="childrenPlaces")
     */
    private $parentPlace;

    /**
     * @ORM\OneToMany(targetEntity=Places::class, mappedBy="parentPlace")
     */
    private $childrenPlaces;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    public function __construct()
    {
        $this->rps = new ArrayCollection();
        $this->childrenPlaces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
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
            $rp->setPlace($this);
        }

        return $this;
    }

    public function removeRp(RP $rp): self
    {
        if ($this->rps->removeElement($rp)) {
            // set the owning side to null (unless already changed)
            if ($rp->getPlace() === $this) {
                $rp->setPlace(null);
            }
        }

        return $this;
    }

    public function getParentPlace(): ?self
    {
        return $this->parentPlace;
    }

    public function setParentPlace(?self $parentPlace): self
    {
        $this->parentPlace = $parentPlace;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getChildrenPlaces(): Collection
    {
        return $this->childrenPlaces;
    }

    public function addChildrenPlace(self $childrenPlace): self
    {
        if (!$this->childrenPlaces->contains($childrenPlace)) {
            $this->childrenPlaces[] = $childrenPlace;
            $childrenPlace->setParentPlace($this);
        }

        return $this;
    }

    public function removeChildrenPlace(self $childrenPlace): self
    {
        if ($this->childrenPlaces->removeElement($childrenPlace)) {
            // set the owning side to null (unless already changed)
            if ($childrenPlace->getParentPlace() === $this) {
                $childrenPlace->setParentPlace(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name; 
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

}
