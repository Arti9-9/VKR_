<?php

namespace App\Entity;

use App\Repository\PatternRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PatternRepository::class)
 */
class Pattern
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $address;

    /**
     * @ORM\Column(type="text")
     */
    private $buildings;

    /**
     * @ORM\Column(type="float")
     */
    private $buildingArea;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $property;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $owner;

    /**
     * @ORM\Column(type="text")
     */
    private $document;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cadastralNumber;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $dateNumber;

    /**
     * @ORM\Column(type="text")
     */
    private $requisites;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getBuildings(): ?string
    {
        return $this->buildings;
    }

    public function setBuildings(string $buildings): self
    {
        $this->buildings = $buildings;

        return $this;
    }

    public function getBuildingArea(): ?float
    {
        return $this->buildingArea;
    }

    public function setBuildingArea(float $buildingArea): self
    {
        $this->buildingArea = $buildingArea;

        return $this;
    }

    public function getProperty(): ?string
    {
        return $this->property;
    }

    public function setProperty(string $property): self
    {
        $this->property = $property;

        return $this;
    }

    public function getOwner(): ?string
    {
        return $this->owner;
    }

    public function setOwner(string $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getDocument(): ?string
    {
        return $this->document;
    }

    public function setDocument(string $document): self
    {
        $this->document = $document;

        return $this;
    }

    public function getCadastralNumber(): ?string
    {
        return $this->cadastralNumber;
    }

    public function setCadastralNumber(string $cadastralNumber): self
    {
        $this->cadastralNumber = $cadastralNumber;

        return $this;
    }

    public function getDateNumber(): ?string
    {
        return $this->dateNumber;
    }

    public function setDateNumber(string $dateNumber): self
    {
        $this->dateNumber = $dateNumber;

        return $this;
    }

    public function getRequisites(): ?string
    {
        return $this->requisites;
    }

    public function setRequisites(string $requisites): self
    {
        $this->requisites = $requisites;

        return $this;
    }
}
