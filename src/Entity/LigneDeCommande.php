<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Repository\LigneDeCommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: LigneDeCommandeRepository::class)]

#[ApiResource(
    collectionOperations:[
        "get",
        "post" => [
            "denormalization_context" => ["groups" => "LT:write"],
            "AbstractObjectNormalizer::ENABLE_MAX_DEPTH"=>true,
        ]
    ]
)]
class LigneDeCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["com:r:a","com:r:s","com:update",])]
    private $id;

    #[ORM\Column(type: 'float')]
    #[Groups(["com:r:a","com:r:s","com:update",])]
    private $prix;

    #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'ligneDeCommandes', cascade:['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["com:r:a","com:r:s","com:write","client:r:a","com:update",])]
    private $produit;

    #[ORM\Column(type: 'float')]
    #[Groups(["com:r:a","com:r:s","com:write","client:r:a","com:update",])]
    private $quantity;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'ligneDeCommandes')]
    #[ORM\JoinColumn(nullable: true)]
    private $commande;

    #[ORM\OneToMany(mappedBy: 'ligneDeCommande', targetEntity: LigneTaille::class, cascade:['persist'])]
    #[Groups(["com:write",])]
    // #[SerializedName("Boissons")]
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
