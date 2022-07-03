<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MenusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenusRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            
        ],
        "post"=>[
            "denormalization_context"=>["groups"=>["M:write","M:p:write"]]
        ]
    ]
)]
class Menus extends Produit
{

    #[ORM\OneToMany(mappedBy: 'menus', targetEntity: Burger::class)]
    #[Groups(["M:p:write"])]
    private $bugers;

    #[ORM\OneToMany(mappedBy: 'menus', targetEntity: Frites::class)]
    #[Groups(["M:p:write"])]
    private $frites;

    #[ORM\OneToMany(mappedBy: 'menus', targetEntity: Boisson::class)]
    #[Groups(["M:p:write"])]
    private $boissons;

    #[ORM\ManyToMany(targetEntity: Taille::class, mappedBy: 'menu')]
    private $tailles;

    public function __construct()
    {
        $this->bugers = new ArrayCollection();
        $this->frites = new ArrayCollection();
        $this->boissons = new ArrayCollection();
        $this->tailles = new ArrayCollection();
    }

    /**
     * @return Collection<int, Burger>
     */
    public function getBugers(): Collection
    {
        return $this->bugers;
    }

    public function addBuger(Burger $buger): self
    {
        if (!$this->bugers->contains($buger)) {
            $this->bugers[] = $buger;
            $buger->setMenus($this);
        }

        return $this;
    }

    public function removeBuger(Burger $buger): self
    {
        if ($this->bugers->removeElement($buger)) {
            // set the owning side to null (unless already changed)
            if ($buger->getMenus() === $this) {
                $buger->setMenus(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Frites>
     */
    public function getFrites(): Collection
    {
        return $this->frites;
    }

    public function addFrite(Frites $frite): self
    {
        if (!$this->frites->contains($frite)) {
            $this->frites[] = $frite;
            $frite->setMenus($this);
        }

        return $this;
    }

    public function removeFrite(Frites $frite): self
    {
        if ($this->frites->removeElement($frite)) {
            // set the owning side to null (unless already changed)
            if ($frite->getMenus() === $this) {
                $frite->setMenus(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Boisson>
     */
    public function getBoissons(): Collection
    {
        return $this->boissons;
    }

    public function addBoisson(Boisson $boisson): self
    {
        if (!$this->boissons->contains($boisson)) {
            $this->boissons[] = $boisson;
            $boisson->setMenus($this);
        }

        return $this;
    }

    public function removeBoisson(Boisson $boisson): self
    {
        if ($this->boissons->removeElement($boisson)) {
            // set the owning side to null (unless already changed)
            if ($boisson->getMenus() === $this) {
                $boisson->setMenus(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Taille>
     */
    public function getTailles(): Collection
    {
        return $this->tailles;
    }

    public function addTaille(Taille $taille): self
    {
        if (!$this->tailles->contains($taille)) {
            $this->tailles[] = $taille;
            $taille->addMenu($this);
        }

        return $this;
    }

    public function removeTaille(Taille $taille): self
    {
        if ($this->tailles->removeElement($taille)) {
            $taille->removeMenu($this);
        }

        return $this;
    }

}
