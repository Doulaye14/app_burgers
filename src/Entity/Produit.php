<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]

#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"type",type:"string")]
#[ORM\DiscriminatorMap(["burger"=>"Burger","menus"=>"Menus","portionfrites"=>"PortionFrites","boisson"=>"Boisson"])]
#[ApiResource]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(
        [
            "T:write","M:p:r:all",
            "M:r:all","M:write",
            "c:r:all","c:write",
            "bg:r:simple","bg:r:all",
            "F:r:all","F:r:simple","F:write"
        ]
    )]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(
        [
            'read:simple','read:all','write',
            "M:r:simple","M:r:all",
            "bg:r:simple","bg:r:all","bg:write",
            "F:r:all","F:r:simple","F:write"
        ]
    )]
    private $nom;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: LigneDeCommande::class)]
    private $ligneDeCommandes;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $image;

    public function __construct()
    {
        $this->ligneDeCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, LigneDeCommande>
     */
    public function getLigneDeCommandes(): Collection
    {
        return $this->ligneDeCommandes;
    }


    public function addLigneDeCommande(LigneDeCommande $ligneDeCommande): self
    {
        if (!$this->ligneDeCommandes->contains($ligneDeCommande)) {
            $this->ligneDeCommandes[] = $ligneDeCommande;
            $ligneDeCommande->setProduit($this);
        }

        return $this;
    }

    public function removeLigneDeCommande(LigneDeCommande $ligneDeCommande): self
    {
        if ($this->ligneDeCommandes->removeElement($ligneDeCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneDeCommande->getProduit() === $this) {
                $ligneDeCommande->setProduit(null);
            }
        }

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

}
