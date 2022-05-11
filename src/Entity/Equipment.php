<?php

namespace App\Entity;

use App\Repository\EquipmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EquipmentRepository::class)
 */
class Equipment
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
    private $Name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Category;

    /**
     * @ORM\ManyToOne(targetEntity=Auditorium::class, inversedBy="Equipment")
     * @ORM\JoinColumn(nullable=false)
     */
    private $auditorium;

    /**
     * @ORM\OneToMany(targetEntity=Attribute::class, mappedBy="equipment")
     */
    private $attributes;

    public function __construct()
    {
        $this->attributes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->Category;
    }

    public function setCategory(?string $Category): self
    {
        $this->Category = $Category;

        return $this;
    }

    public function getAuditorium(): ?Auditorium
    {
        return $this->auditorium;
    }

    public function setAuditorium(?Auditorium $auditorium): self
    {
        $this->auditorium = $auditorium;

        return $this;
    }

    /**
     * @return Collection<int, Attribute>
     */
    public function getAttributes(): Collection
    {
        return $this->attributes;
    }

    public function addAttribute(Attribute $attribute): self
    {
        if (!$this->attributes->contains($attribute)) {
            $this->attributes[] = $attribute;
            $attribute->setEquipment($this);
        }

        return $this;
    }

    public function removeAttribute(Attribute $attribute): self
    {
        if ($this->attributes->removeElement($attribute)) {
            // set the owning side to null (unless already changed)
            if ($attribute->getEquipment() === $this) {
                $attribute->setEquipment(null);
            }
        }

        return $this;
    }
}
