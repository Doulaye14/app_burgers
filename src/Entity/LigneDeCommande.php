<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LigneDeCommandeRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LigneDeCommandeRepository::class)]
class LigneDeCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float')]
    #[Groups(["c:r:all","c:r:simple"])]
    private $prix;

    #[ORM\Column(type: 'float')]
    #[Groups(["c:r:all","c:r:simple","c:write"])]
    private $quantity;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'ligneDeCommandes')]
    #[ORM\JoinColumn(nullable: false)]
    private $commande;

    #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'ligneDeCommandes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["c:r:all","c:r:simple","c:write"])]
    private $produit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;
        return $this;
    }

    
}
