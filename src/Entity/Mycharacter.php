<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MycharacterRepository")
 */
class Mycharacter
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Health;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $maxHealth;

    /**
     * @ORM\Column(type="integer")
     */
    private $STR;

    /**
     * @ORM\Column(type="integer")
     */
    private $WIS;

    /**
     * @ORM\Column(type="integer")
     */
    private $DEX;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Weapon", mappedBy="FK_Mycharacter")
     */
    private $weapon;

    public function __construct()
    {
        $this->weapon = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getHealth(): ?int
    {
        return $this->Health;
    }

    public function setHealth(?int $Health): self
    {
        $this->Health = $Health;

        return $this;
    }

    public function getMaxHealth(): ?int
    {
        return $this->maxHealth;
    }

    public function setMaxHealth(?int $maxHealth): self
    {
        $this->maxHealth = $maxHealth;

        return $this;
    }

    public function getSTR(): ?int
    {
        return $this->STR;
    }

    public function setSTR(int $STR): self
    {
        $this->STR = $STR;

        return $this;
    }

    public function getWIS(): ?int
    {
        return $this->WIS;
    }

    public function setWIS(int $WIS): self
    {
        $this->WIS = $WIS;

        return $this;
    }

    public function getDEX(): ?int
    {
        return $this->DEX;
    }

    public function setDEX(int $DEX): self
    {
        $this->DEX = $DEX;

        return $this;
    }

    /**
     * @return Collection|Weapon[]
     */
    public function getWeapon(): Collection
    {
        return $this->weapon;
    }

    public function addWeapon(Weapon $weapon): self
    {
        if (!$this->weapon->contains($weapon)) {
            $this->weapon[] = $weapon;
            $weapon->setFKMycharacter($this);
        }

        return $this;
    }

    public function removeWeapon(Weapon $weapon): self
    {
        if ($this->weapon->contains($weapon)) {
            $this->weapon->removeElement($weapon);
            // set the owning side to null (unless already changed)
            if ($weapon->getFKMycharacter() === $this) {
                $weapon->setFKMycharacter(null);
            }
        }

        return $this;
    }
}
