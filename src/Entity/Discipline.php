<?php

namespace App\Entity;

use App\Repository\DisciplineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DisciplineRepository::class)
 */
class Discipline
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
     * @ORM\ManyToMany(targetEntity=Curriculum::class, mappedBy="disciplines")
     */
    private $curricula;

    /**
     * @ORM\OneToMany(targetEntity=Schedule::class, mappedBy="discipline", orphanRemoval=true)
     */
    private $schedules;




    public function __construct()
    {
        $this->curricula = new ArrayCollection();
        $this->schedules = new ArrayCollection();
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

    /**
     * @return Collection<int, Curriculum>
     */
    public function getCurricula(): Collection
    {
        return $this->curricula;
    }

    public function addCurriculum(Curriculum $curriculum): self
    {
        if (!$this->curricula->contains($curriculum)) {
            $this->curricula[] = $curriculum;
            $curriculum->addDiscipline($this);
        }

        return $this;
    }

    public function removeCurriculum(Curriculum $curriculum): self
    {
        if ($this->curricula->removeElement($curriculum)) {
            $curriculum->removeDiscipline($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Schedule>
     */
    public function getSchedules(): Collection
    {
        return $this->schedules;
    }

    public function addSchedule(Schedule $schedule): self
    {
        if (!$this->schedules->contains($schedule)) {
            $this->schedules[] = $schedule;
            $schedule->setDiscipline($this);
        }

        return $this;
    }

    public function removeSchedule(Schedule $schedule): self
    {
        if ($this->schedules->removeElement($schedule)) {
            // set the owning side to null (unless already changed)
            if ($schedule->getDiscipline() === $this) {
                $schedule->setDiscipline(null);
            }
        }

        return $this;
    }

}
