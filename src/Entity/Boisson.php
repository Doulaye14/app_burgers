<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BoissonRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            "status"=>Response::HTTP_OK,
            "normalization_context" => ["groups" => ["B:read:simple"]]
        ],
        "post"=>[
            "denormalization_context" => ["groups"=>["B:write"]],
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas accès à cette ressource"
        ]
    ],
    itemOperations:[
        "get",
        "put"=>[
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas accès à cette ressource"
        ]
    ]
)]
class Boisson extends Complement
{

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["B:read:simple","B:write"])]
    private $taille;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["B:read:simple","B:write"])]
    private $variete;

    #[ORM\ManyToOne(targetEntity: Menus::class, inversedBy: 'boissons')]
    private $menus;

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(string $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getVariete(): ?string
    {
        return $this->variete;
    }

    public function setVariete(string $variete): self
    {
        $this->variete = $variete;

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
