<?php

namespace App\Entity;

use App\Repository\AtributesForRequirementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AtributesForRequirementRepository::class)
 */
class AtributesForRequirement
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
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $unit;

    /**
     * @ORM\ManyToOne(targetEntity=Requirements::class, inversedBy="atributes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $requipment;

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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(?string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getRequipment(): ?Requirements
    {
        return $this->requipment;
    }

    public function setRequipment(?Requirements $requipment): self
    {
        $this->requipment = $requipment;

        return $this;
    }
}
