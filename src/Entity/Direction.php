<?php

namespace App\Entity;

use App\Repository\DirectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DirectionRepository::class)
 */
class Direction
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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="direction")
     * @ORM\JoinColumn(nullable=false)
     */
    private $responsible;

    /**
     * @ORM\OneToMany(targetEntity=Curriculum::class, mappedBy="direction", orphanRemoval=true)
     */
    private $curriculum;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $nameGroup;



    public function __construct()
    {
        $this->curriculum = new ArrayCollection();
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

    public function getResponsible(): ?User
    {
        return $this->responsible;
    }

    public function setResponsible(?User $responsible): self
    {
        $this->responsible = $responsible;

        return $this;
    }

    /**
     * @return Collection<int, Curriculum>
     */
    public function getCurriculum(): Collection
    {
        return $this->curriculum;
    }

    public function addCurriculum(Curriculum $curriculum): self
    {
        if (!$this->curriculum->contains($curriculum)) {
            $this->curriculum[] = $curriculum;
            $curriculum->setDirection($this);
        }

        return $this;
    }

    public function removeCurriculum(Curriculum $curriculum): self
    {
        if ($this->curriculum->removeElement($curriculum)) {
            // set the owning side to null (unless already changed)
            if ($curriculum->getDirection() === $this) {
                $curriculum->setDirection(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->Name;
    }

    public function getNameGroup(): ?string
    {
        return $this->nameGroup;
    }

    public function setNameGroup(string $nameGroup): self
    {
        $this->nameGroup = $nameGroup;

        return $this;
    }

}
