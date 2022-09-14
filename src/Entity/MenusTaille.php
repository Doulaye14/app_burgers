<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenusTailleRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenusTailleRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            "status"=>Response::HTTP_OK,
            "normalization_context" => ["Groups" =>["MT:r:simple"]]
        ],
        "post"
    ],
    itemOperations:[
        "get"=>[
            "status"=>Response::HTTP_OK,
            "normalization_context" => ["Groups" =>["MT:r:all"]]
        ],
        "put"
    ]
)]
class MenusTaille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["Menus:w","produit:r:a"])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(["Menus:w","produit:r:a"])]
    private $quantity;

    #[ORM\ManyToOne(targetEntity: Menus::class, inversedBy: 'menusTailles')]
    #[ORM\JoinColumn(nullable: false)]
    private $menu;

    #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'menusTailles')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["Menus:w","produit:r:a"])]
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
