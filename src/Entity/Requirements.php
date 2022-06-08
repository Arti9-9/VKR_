<?php

namespace App\Entity;

use App\Repository\RequirementsRepository;
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
}
