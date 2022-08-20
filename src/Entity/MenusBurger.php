<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenusBurgerRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenusBurgerRepository::class)]
#[ApiResource(
    
)]
class MenusBurger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["Menus:r:s","produit:r:a","Menus:r:a"])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(["Menus:r:s","Menus:w","produit:r:a","Menus:r:a"])]
    private $quantity;

    #[ORM\ManyToOne(targetEntity: Menus::class, inversedBy: 'menusBurgers')]
    private $menu;

    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'menusBurgers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["Menus:r:s","Menus:w","produit:r:a"])]
    private $burger;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getMenu(): ?Menus
    {
        return $this->menu;
    }

    public function setMenu(?Menus $menu): self
    {
        $this->menu = $menu;
        return $this;
    }

    public function getBurger(): ?Burger
    {
        return $this->burger;
    }

    public function setBurger(?Burger $burger): self
    {
        $this->burger = $burger;

        return $this;
    }
}
