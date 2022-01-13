<?php

namespace App\Entity;

use App\Repository\RPRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=RPRepository::class)
 */
class RP
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
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Places::class, inversedBy="rps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $place;

    /**
     * @ORM\Column(type="datetime")
     */
    private $happensAt;

    /**
     * @ORM\OneToMany(targetEntity=RPPost::class, mappedBy="rpIn", orphanRemoval=true, cascade={"persist"})
     */
    private $rPPosts;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    public function __construct()
    {
        $this->involvedCharacters = new ArrayCollection();
        $this->rPPosts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getPlace(): ?Places
    {
        return $this->place;
    }

    public function setPlace(?Places $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getHappensAt(): ?\DateTimeInterface
    {
        return $this->happensAt;
    }

    public function setHappensAt(\DateTimeInterface $happensAt): self
    {
        $this->happensAt = $happensAt;

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
            $rPPost->setRpIn($this);
        }

        return $this;
    }

    public function removeRPPost(RPPost $rPPost): self
    {
        if ($this->rPPosts->removeElement($rPPost)) {
            // set the owning side to null (unless already changed)
            if ($rPPost->getRpIn() === $this) {
                $rPPost->setRpIn(null);
            }
        }

        return $this;
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
