<?php

namespace App\Entity;

use App\Repository\ScheduleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ScheduleRepository::class)
 */
class Schedule
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $groupName;

    /**
     * @ORM\ManyToOne(targetEntity=Auditorium::class, inversedBy="schedules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $auditorium;

    /**
     * @ORM\ManyToOne(targetEntity=Discipline::class, inversedBy="schedules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $discipline;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroupName(): ?string
    {
        return $this->groupName;
    }

    public function setGroupName(string $groupName): self
    {
        $this->groupName = $groupName;

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
