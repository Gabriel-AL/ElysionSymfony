<?php

namespace App\Entity;

use App\Repository\DemandRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DemandRepository::class)
 */
class Demand
{
    private const TYPE_OF_DEMAND = [
        1 => "Shops"
    ];
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="demands")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fromAccount;

    /**
     * @ORM\Column(type="smallint")
     */
    private $typeOfDemand;

    /**
     * @ORM\Column(type="json")
     */
    private $content = [];

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $approvedBy = [];

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromAccount(): ?Account
    {
        return $this->fromAccount;
    }

    public function setFromAccount(?Account $fromAccount): self
    {
        $this->fromAccount = $fromAccount;

        return $this;
    }

    public function getTypeOfDemand(): ?int
    {
        return $this->typeOfDemand;
    }

    public function setTypeOfDemand(int $typeOfDemand): self
    {
        $this->typeOfDemand = $typeOfDemand;

        return $this;
    }

    public function getContent(): ?array
    {
        return $this->content;
    }

    public function setContent(array $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getApprovedBy(): ?array
    {
        return $this->approvedBy;
    }

    public function setApprovedBy(?array $approvedBy): self
    {
        $this->approvedBy = $approvedBy;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
