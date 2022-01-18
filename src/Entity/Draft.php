<?php

namespace App\Entity;

use App\Repository\DraftRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DraftRepository::class)
 */
class Draft
{
    private const TYPE_OF_DRAFT = [
        1 => "PlayedCharacter",
        2 => "RPPost",
        2 => "PrivateMessage"
    ];
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="drafts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fromAccount;

    /**
     * @ORM\Column(type="smallint")
     */
    private $typeOfDraft;

    /**
     * @ORM\Column(type="json")
     */
    private $content = [];

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

    public function getTypeOfDraft(): ?int
    {
        return $this->typeOfDraft;
    }

    public function setTypeOfDraft(int $typeOfDraft): self
    {
        $this->typeOfDraft = $typeOfDraft;

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
}
