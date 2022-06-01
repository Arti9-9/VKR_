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



    public function __construct()
    {
        $this->curricula = new ArrayCollection();
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

}
