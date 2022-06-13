<?php

namespace App\Entity;

use App\Repository\CurriculumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreate;

    /**
     * @ORM\ManyToMany(targetEntity=Discipline::class, inversedBy="curricula")
     */
    private $disciplines;

    /**
     * @ORM\OneToMany(targetEntity=Requirements::class, mappedBy="curriculum", orphanRemoval=true)
     */
    private $requirements;




    public function __construct()
    {
        $this->disciplines = new ArrayCollection();
        $this->requirements = new ArrayCollection();
    }




    public function __toString()
    {
        return $this->Name;
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

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->dateCreate;
    }

    public function setDateCreate(\DateTimeInterface $dateCreate): self
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    /**
     * @return Collection<int, Discipline>
     */
    public function getDisciplines(): Collection
    {
        return $this->disciplines;
    }

    public function addDiscipline(Discipline $discipline): self
    {
        if (!$this->disciplines->contains($discipline)) {
            $this->disciplines[] = $discipline;
        }

        return $this;
    }

    public function removeDiscipline(Discipline $discipline): self
    {
        $this->disciplines->removeElement($discipline);

        return $this;
    }

    /**
     * @return Collection<int, Requirements>
     */
    public function getRequirements(): Collection
    {
        return $this->requirements;
    }

    public function addRequirement(Requirements $requirement): self
    {
        if (!$this->requirements->contains($requirement)) {
            $this->requirements[] = $requirement;
            $requirement->setCurriculum($this);
        }

        return $this;
    }

    public function removeRequirement(Requirements $requirement): self
    {
        if ($this->requirements->removeElement($requirement)) {
            // set the owning side to null (unless already changed)
            if ($requirement->getCurriculum() === $this) {
                $requirement->setCurriculum(null);
            }
        }

        return $this;
    }



}
