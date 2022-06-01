<?php

namespace App\Entity;

use App\Repository\AuditoriumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AuditoriumRepository::class)
 */
class Auditorium
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $CountSeats;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $Number;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $Square;

    /**
     * @ORM\OneToMany(targetEntity=Equipment::class, mappedBy="auditorium")
     */
    private $Equipment;


    public function __construct()
    {
        $this->Equipment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountSeats(): ?int
    {
        return $this->CountSeats;
    }

    public function setCountSeats(?int $CountSeats): self
    {
        $this->CountSeats = $CountSeats;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->Number;
    }

    public function setNumber(string $Number): self
    {
        $this->Number = $Number;

        return $this;
    }

    public function getSquare(): ?float
    {
        return $this->Square;
    }

    public function setSquare(?float $Square): self
    {
        $this->Square = $Square;

        return $this;
    }

    /**
     * @return Collection<int, Equipment>
     */
    public function getEquipment(): Collection
    {
        return $this->Equipment;
    }

    public function addEquipment(Equipment $equipment): self
    {
        if (!$this->Equipment->contains($equipment)) {
            $this->Equipment[] = $equipment;
            $equipment->setAuditorium($this);
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): self
    {
        if ($this->Equipment->removeElement($equipment)) {
            // set the owning side to null (unless already changed)
            if ($equipment->getAuditorium() === $this) {
                $equipment->setAuditorium(null);
            }
        }

        return $this;
    }

}
