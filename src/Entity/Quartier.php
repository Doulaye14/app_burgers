<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuartierRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuartierRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            "status" => Response::HTTP_OK,
            "normalization_context" => ["groups"=>["Q:r:simple"]],
        ],
        "post"=>[
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas accès à cette ressouce !",
            "denormalization_context" => ["groups"=>["Q:write"]],
            "normalization_context" => ["groups"=>["Q:r:p"]]
        ]
    ],
    itemOperations:[
        "get"=>[
            "normalization_context" => ["groups"=>["Q:r:all"]],
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas accès à cette ressouce !",
        ],
        "put"=>[
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas accès à cette ressouce !"
        ]
    ]
)]
class Quartier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["read:all","Q:r:p"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["Q:r:simple","Q:r:all","Q:write","Q:r:p"])]
    private $nom;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'quartiers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["Q:r:simple","Q:r:all","Q:write","Q:r:p"])]
    private $zone;

    public function __construct()
    {
        $this->livraisons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

}
