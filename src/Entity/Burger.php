<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource(
    collectionOperations:
    [
        "get"=>[
            'status' => Response::HTTP_OK,
            'normalization_context' => ['groups' => ['read:simple']]
        ],
        "post"=>[
            'denormalization_context' => ['groups' => ['write']],
            'normalization_context' => ['groups' => ['read:all']],
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas accès à cette ressource"
        ]
    ],
    itemOperations:
    [
        "get"=>[
            'status' => Response::HTTP_OK,
            'normalization_context' => ['groups' => ['read:all']],
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas accès à cette ressource"
        ],
        "put"=>[
            'normalization_context' => ['groups' => ['read:all']],
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas accès à cette ressource"
        ]
    ]
)]
class Burger extends Produit
{

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:simple','read:all','write'])]
    private $categorie;

    #[ORM\ManyToOne(targetEntity: Menus::class, inversedBy: 'bugers')]
    private $menus;

    #[ORM\Column(type: 'boolean')]
    #[Groups('read:all')]
    private $isEtat= true;

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

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

    public function isIsEtat(): ?bool
    {
        return $this->isEtat;
    }

    public function setIsEtat(bool $isEtat): self
    {
        $this->isEtat = $isEtat;

        return $this;
    }

}
