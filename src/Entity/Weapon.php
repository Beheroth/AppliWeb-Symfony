<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WeaponRepository")
 */
class Weapon
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
    private $damage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Mycharacter", inversedBy="weapon")
     */
    private $FK_Mycharacter;

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

    public function getDamage(): ?int
    {
        return $this->damage;
    }

    public function setDamage(?int $damage): self
    {
        $this->damage = $damage;

        return $this;
    }

    public function getFKMycharacter(): ?Mycharacter
    {
        return $this->FK_Mycharacter;
    }

    public function setFKMycharacter(?Mycharacter $FK_Mycharacter): self
    {
        $this->FK_Mycharacter = $FK_Mycharacter;

        return $this;
    }
}
