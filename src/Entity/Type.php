<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TypeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
#[ApiResource]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(
        [
            'Menus:w','burger:w','produit:r:s','produit:r:a'
        ]
    )]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(
        [
            'produit:r:s','produit:r:a'
            // "M:r:simple","M:r:all","por:write","M:p:r:all",
            // "bg:r:simple","bg:r:all","bg:write",
            // "F:r:all","F:r:simple","F:write",
            // "prod:r:all"
        ]
    )]
    private $libele;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Produit::class)]
    private $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibele(): ?string
    {
        return $this->libele;
    }

    public function setLibele(string $libele): self
    {
        $this->libele = $libele;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setType($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getType() === $this) {
                $produit->setType(null);
            }
        }

        return $this;
    }
}
