<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MenusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenusRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            
        ],
        "post"=>[
            
        ]
    ]
)]
class Menus extends Produit
{

    #[ORM\OneToMany(mappedBy: 'menus', targetEntity: Burger::class)]
    private $bugers;

    #[ORM\OneToMany(mappedBy: 'menus', targetEntity: Frites::class)]
    private $frites;

    #[ORM\OneToMany(mappedBy: 'menus', targetEntity: Boisson::class)]
    private $boissons;

    public function __construct()
    {
        $this->bugers = new ArrayCollection();
        $this->frites = new ArrayCollection();
        $this->boissons = new ArrayCollection();
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

}
