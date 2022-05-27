<?php

namespace App\Entity;

use App\Repository\CurriculumRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CurriculumRepository::class)
 */
class Curriculum
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
    private $Name;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $EducationalProgram;

    /**
     * @ORM\ManyToOne(targetEntity=Direction::class, inversedBy="curriculum")
     * @ORM\JoinColumn(nullable=false)
     */
    private $direction;


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

    public function getEducationalProgram(): ?string
    {
        return $this->EducationalProgram;
    }

    public function setEducationalProgram(?string $EducationalProgram): self
    {
        $this->EducationalProgram = $EducationalProgram;

        return $this;
    }

    public function getDirection(): ?Direction
    {
        return $this->direction;
    }

    public function setDirection(?Direction $direction): self
    {
        $this->direction = $direction;

        return $this;
    }
}
