<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScenarioRepository")
 */
class Scenario
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1023, nullable=true)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $GM;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Mycharacter")
     */
    private $Mycharacters;

    public function __construct()
    {
        $this->Mycharacters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getGM(): ?string
    {
        return $this->GM;
    }

    public function setGM(string $GM): self
    {
        $this->GM = $GM;

        return $this;
    }

    /**
     * @return Collection|Mycharacter[]
     */
    public function getMycharacters(): Collection
    {
        return $this->Mycharacters;
    }

    public function addMycharacter(Mycharacter $mycharacter): self
    {
        if (!$this->Mycharacters->contains($mycharacter)) {
            $this->Mycharacters[] = $mycharacter;
        }

        return $this;
    }

    public function removeMycharacter(Mycharacter $mycharacter): self
    {
        if ($this->Mycharacters->contains($mycharacter)) {
            $this->Mycharacters->removeElement($mycharacter);
        }

        return $this;
    }
}
