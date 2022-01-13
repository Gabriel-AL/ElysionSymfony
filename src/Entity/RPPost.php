<?php

namespace App\Entity;

use App\Repository\RPPostRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RPPostRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class RPPost
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=RP::class, inversedBy="rPPosts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rpIn;

    /**
     * @ORM\ManyToOne(targetEntity=PlayedCharacter::class, inversedBy="rPPosts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $poster;

    /**
     * @ORM\Column(type="datetime")
     */
    private $postedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class)
     */
    private $updatedBy;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRpIn(): ?RP
    {
        return $this->rpIn;
    }

    public function setRpIn(?RP $rpIn): self
    {
        $this->rpIn = $rpIn;

        return $this;
    }

    public function getPoster(): ?PlayedCharacter
    {
        return $this->poster;
    }

    public function setPoster(?PlayedCharacter $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getPostedAt(): ?\DateTimeInterface
    {
        return $this->postedAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function setPostedAt(): self
    {
        $this->postedAt = new DateTimeImmutable();

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PreFlush
     */
    public function setUpdatedAt(): self
    {
        $this->updatedAt = new DateTimeImmutable();

        return $this;
    }

    public function getUpdatedBy(): ?Account
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?Account $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
