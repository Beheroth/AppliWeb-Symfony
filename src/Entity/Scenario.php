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
    private $description;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $gm;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Mycharacter")
     */
    private $mycharacters;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    public function __construct()
    {
        $this->mycharacters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getGM(): ?string
    {
        return $this->gm;
    }

    public function setGM(string $gm): self
    {
        $this->gm = $gm;

        return $this;
    }

    /**
     * @return Collection|mycharacter[]
     */
    public function getMycharacters(): Collection
    {
        return $this->mycharacters;
    }

    public function addMycharacter(Mycharacter $mycharacter): self
    {
        if (!$this->mycharacters->contains($mycharacter)) {
            $this->mycharacters[] = $mycharacter;
        }

        return $this;
    }

    public function removeMycharacter(Mycharacter $mycharacter): self
    {
        if ($this->mycharacters->contains($mycharacter)) {
            $this->mycharacters->removeElement($mycharacter);
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
