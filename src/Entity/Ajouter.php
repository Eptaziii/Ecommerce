<?php

namespace App\Entity;

use App\Repository\AjouterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AjouterRepository::class)]
class Ajouter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\ManyToOne(inversedBy: 'ajouters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Jeux $jeux = null;

    #[ORM\ManyToOne(inversedBy: 'ajouters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Panier $panier = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getJeux(): ?Jeux
    {
        return $this->jeux;
    }

    public function setJeux(?Jeux $jeux): static
    {
        $this->jeux = $jeux;

        return $this;
    }

    public function getPanier(): ?Panier
    {
        return $this->panier;
    }

    public function setPanier(?Panier $panier): static
    {
        $this->panier = $panier;

        return $this;
    }
}
