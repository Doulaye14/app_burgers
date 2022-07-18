<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenusTailleRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenusTailleRepository::class)]
#[ApiResource]
class MenusTaille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["M:r:all","M:write","M:p:r:all"])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(["M:r:all","M:write","M:p:r:all"])]
    private $quantity;

    #[ORM\ManyToOne(targetEntity: Menus::class, inversedBy: 'menusTailles')]
    #[ORM\JoinColumn(nullable: false)]
    private $menu;

    #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'menusTailles')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["M:r:all","M:write","M:p:r:all"])]
    private $taille;

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

    public function getTaille(): ?Taille
    {
        return $this->taille;
    }

    public function setTaille(?Taille $taille): self
    {
        $this->taille = $taille;

        return $this;
    }
}
