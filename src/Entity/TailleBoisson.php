<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TailleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TailleRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            "status"=> Response::HTTP_OK,
            "normalization_context" => ["groups" => ["T:r:simple"]]
        ],
        "post"=>[
            "denormalization_context" => ["groups" => ["T:write"]]
        ]   
    ],
    itemOperations:[
        "get"=>[
            "seciruty" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez accès à cette ressource !",
            "normalization_context" => ["groups" => ["T:r:all"]]
        ],
        "put"=>[
            "seciruty" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez accès à cette ressource !"
        ]
    ]
)]
class TailleBoisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["T:r:all","M:r:simple","M:r:all","M:write","M2:write"])]
    private $id;

    #[ORM\ManyToOne(targetEntity: Boisson::class, inversedBy: 'tailleBoissons')]
    private $boisson;

    #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'tailleBoissons')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["write"])]
    private $taille;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBoisson(): ?Boisson
    {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): self
    {
        $this->boisson = $boisson;

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
