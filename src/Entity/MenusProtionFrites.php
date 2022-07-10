<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MenusProtionFritesRepository;
use Symfony\Component\Serializer\Annotation\Groups;
#[ApiResource]
#[ORM\Entity(repositoryClass: MenusProtionFritesRepository::class)]
class MenusProtionFrites
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["M:r:all","M:write",])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(["M:r:simple","M:r:all","M:write",])]
    private $quantity;

    #[ORM\ManyToOne(targetEntity: PortionFrites::class, inversedBy: 'menusPortionFrites')]
    #[Groups(["M:r:simple","M:r:all","M:write",])]
    private $portionFrites;

    #[ORM\ManyToOne(targetEntity: Menus::class, inversedBy: 'menusPortionFrites')]
    #[ORM\JoinColumn(nullable: false)]
    private $menus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPortionFrites(): ?PortionFrites
    {
        return $this->portionFrites;
    }

    public function setPortionFrites(?PortionFrites $portionFrites): self
    {
        $this->portionFrites = $portionFrites;

        return $this;
    }

    public function getMenus(): ?Menus
    {
        return $this->menus;
    }

    public function setMenus(?Menus $menus): self
    {
        $this->menus = $menus;

        return $this;
    }


    /**
     * Get the value of quantity
     */ 
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */ 
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }   
}
