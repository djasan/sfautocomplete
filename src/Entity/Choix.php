<?php

namespace App\Entity;

use App\Repository\ChoixRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChoixRepository::class)]
class Choix
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(targetEntity: Simple::class, mappedBy: 'choix')]
    private Collection $simples;

    #[ORM\ManyToMany(targetEntity: Multiple::class, mappedBy: 'choix')]
    private Collection $multiples;

    public function __construct()
    {
        $this->simples = new ArrayCollection();
        $this->multiples = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Simple>
     */
    public function getSimples(): Collection
    {
        return $this->simples;
    }

    public function addSimple(Simple $simple): static
    {
        if (!$this->simples->contains($simple)) {
            $this->simples->add($simple);
            $simple->setChoix($this);
        }

        return $this;
    }

    public function removeSimple(Simple $simple): static
    {
        if ($this->simples->removeElement($simple)) {
            // set the owning side to null (unless already changed)
            if ($simple->getChoix() === $this) {
                $simple->setChoix(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Multiple>
     */
    public function getMultiples(): Collection
    {
        return $this->multiples;
    }

    public function addMultiple(Multiple $multiple): static
    {
        if (!$this->multiples->contains($multiple)) {
            $this->multiples->add($multiple);
            $multiple->addChoix($this);
        }

        return $this;
    }

    public function removeMultiple(Multiple $multiple): static
    {
        if ($this->multiples->removeElement($multiple)) {
            $multiple->removeChoix($this);
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->nom;
    }


}
