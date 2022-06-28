<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FritesRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FritesRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            "status" => Response::HTTP_OK,
            "normalization_context" => ["groups"=>["F:read:simple"]],
        ],
        "post"=>[
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas accès à cette ressouce !",
            "denormalization_context" => ["groups"=>["F:write"]]
        ]
    ],
    itemOperations:[
        "get",
        "put"
    ]
)]
class Frites extends Complement
{
    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    #[Groups(["F:read:simple","F:write"])]
    private $lot;

    #[ORM\ManyToOne(targetEntity: Menus::class, inversedBy: 'frites')]
    private $menus;

    public function getLot(): ?string
    {
        return $this->lot;
    }

    public function setLot(?string $lot): self
    {
        $this->lot = $lot;

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
}
