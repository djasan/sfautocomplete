<?php

namespace App\Entity;

use App\Repository\SimpleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SimpleRepository::class)]
class Simple
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'simples')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Choix $choix = null;

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

    public function getChoix(): ?Choix
    {
        return $this->choix;
    }

    public function setChoix(?Choix $choix): static
    {
        $this->choix = $choix;

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }



}
