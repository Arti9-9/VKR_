<?php

namespace App\Entity;

use App\Repository\RequirementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RequirementsRepository::class)
 */
class Requirements
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
    private $nameEquipment;

    /**
     * @ORM\ManyToOne(targetEntity=Curriculum::class, inversedBy="requirements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $curriculum;

    /**
     * @ORM\ManyToOne(targetEntity=Discipline::class, inversedBy="requirements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $discipline;

    /**
     * @ORM\OneToMany(targetEntity=AtributesForRequirement::class, mappedBy="requipment", orphanRemoval=true)
     */
    private $atributes;

    public function __construct()
    {
        $this->atributes = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameEquipment(): ?string
    {
        return $this->nameEquipment;
    }

    public function setNameEquipment(string $nameEquipment): self
    {
        $this->nameEquipment = $nameEquipment;

        return $this;
    }

    public function getCurriculum(): ?Curriculum
    {
        return $this->curriculum;
    }

    public function setCurriculum(?Curriculum $curriculum): self
    {
        $this->curriculum = $curriculum;

        return $this;
    }

    public function getDiscipline(): ?Discipline
    {
        return $this->discipline;
    }

    public function setDiscipline(?Discipline $discipline): self
    {
        $this->discipline = $discipline;

        return $this;
    }

    /**
     * @return Collection<int, AtributesForRequirement>
     */
    public function getAtributes(): Collection
    {
        return $this->atributes;
    }

    public function addAtribute(AtributesForRequirement $atribute): self
    {
        if (!$this->atributes->contains($atribute)) {
            $this->atributes[] = $atribute;
            $atribute->setRequipment($this);
        }

        return $this;
    }

    public function removeAtribute(AtributesForRequirement $atribute): self
    {
        if ($this->atributes->removeElement($atribute)) {
            // set the owning side to null (unless already changed)
            if ($atribute->getRequipment() === $this) {
                $atribute->setRequipment(null);
            }
        }

        return $this;
    }
}
