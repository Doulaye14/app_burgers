<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivraisonRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            "status"=>Response::HTTP_OK,
            "normalization_context"=>["groups"=>["L:r:simple"], "AbstractObjectNormalizer::ENABLE_MAX_DEPTH"=>true],
        ],
        "post"=>[
            // "security"=>"is_granted('ROLE_GESTIONNAIRE')",
            // "security_message"=>"Vous n'avez accès à cette ressource !",
            "denormalization_context" => ["groups" => ["L:write"]]
        ]
    ],
    itemOperations:[
        "get"=>[
            // "security"=>"is_granted('ROLE_GESTIONNAIRE')",
            // "security_message"=>"Vous n'avez accès à cette ressource !",
            "normalization_context"=>["groups"=>["L:r:all"]],
        ],
        "put"=>[
            // "security"=>"is_granted('ROLE_GESTIONNAIRE')",
            // "security_message"=>"Vous n'avez accès à cette ressource !"
        ]
    ]

)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["L:r:all","L:r:simple","user:r:s","lvr:r:a"])]
    private $id;

    #[ORM\ManyToOne(targetEntity: Livreur::class, inversedBy: 'livraisons')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["L:r:simple","L:write"])]
    #[MaxDepth(3)]
    private $livreur;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'livraisons')]
    #[Groups(["L:r:simple","L:r:all","L:write","user:r:s","lvr:r:a","L:r:all"])]
    #[MaxDepth(3)]
    private $zone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLivreur(): ?Livreur
    {
        return $this->livreur;
    }

    public function setLivreur(?Livreur $livreur): self
    {
        $this->livreur = $livreur;

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
