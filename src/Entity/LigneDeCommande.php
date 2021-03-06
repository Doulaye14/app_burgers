<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Repository\LigneDeCommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

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

    #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'ligneDeCommandes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["c:r:all","c:r:simple","c:write"])]
    private $produit;

    #[ORM\Column(type: 'float')]
    #[Groups(["c:r:all","c:r:simple","c:write"])]
    private $quantity;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'ligneDeCommandes')]
    #[ORM\JoinColumn(nullable: true)]
    private $commande;

    #[ORM\OneToMany(mappedBy: 'ligneDeCommande', targetEntity: LigneTaille::class, cascade:['persist'])]
    #[Groups(["c:r:all","c:r:simple","c:write"])]
    #[SerializedName("Boissons")]
    private $ligneTailles;

    public function __construct()
    {
        // $this->prix = $this->prixLigne();
        $this->ligneTailles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function prixLigne(){
        $price = $this->getProduit()->getPrix()*$this->getQuantity();
        return $price;
    }

    /**
     * @return Collection<int, LigneTaille>
     */
    public function getLigneTailles(): Collection
    {
        return $this->ligneTailles;
    }

    public function addLigneTaille(LigneTaille $ligneTaille): self
    {
        if (!$this->ligneTailles->contains($ligneTaille)) {
            $this->ligneTailles[] = $ligneTaille;
            $ligneTaille->setLigneDeCommande($this);
        }

        return $this;
    }

    public function removeLigneTaille(LigneTaille $ligneTaille): self
    {
        if ($this->ligneTailles->removeElement($ligneTaille)) {
            // set the owning side to null (unless already changed)
            if ($ligneTaille->getLigneDeCommande() === $this) {
                $ligneTaille->setLigneDeCommande(null);
            }
        }

        return $this;
    }
    
}
