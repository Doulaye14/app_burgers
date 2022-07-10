<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MenusTailleBoissonRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource]
#[ORM\Entity(repositoryClass: MenusTailleBoissonRepository::class)]
class MenusTailleBoisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["M:r:all","M:write",])]
    private $id;


    #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'menusTailleBoissons')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["M:r:all","M:write",])]
    private $taille;

    #[ORM\ManyToOne(targetEntity: Menus::class, inversedBy: 'menusTailleBoissons')]
    #[ORM\JoinColumn(nullable: false)]
    private $menus;

    #[ORM\Column(type: 'integer', nullable: false)]
    #[Groups(["M:r:all","M:write",])]
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaille(): ?Taille
    {
        return $this->taille;
    }

    public function setTaille(?Taille $taille): self
    {
        $this->taille = $taille;

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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
