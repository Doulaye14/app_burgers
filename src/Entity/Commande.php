<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;


#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            "status"=> Response::HTTP_OK,
            "normalization_context"=>["groups" => ["com:r:s"], "AbstractObjectNormalizer::ENABLE_MAX_DEPTH"=>true],
        ],
        "post"=>[
            "denormalization_context"=>["groups" => ["com:write"],"AbstractObjectNormalizer::ENABLE_MAX_DEPTH"=>true],
        ]
    ],
    itemOperations:[
        "get"=>[
            "status"=> Response::HTTP_OK,
            "normalization_context"=>["groups" => "com:r:a"]
        ],
        "put"=>[
            "denormalization_context"=>["groups" => ["com:write"]]
        ]
    ]
)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["com:r:a","com:r:s","read:simple","read:all","L:r:simple","L:r:all","client:r:a"])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(["com:r:a","com:r:s","read:simple","read:all","client:r:a"])]
    private $prixTotal;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["com:r:a","com:r:s","com:write","read:simple","read:all","L:r:simple","L:r:all","client:r:a"])]
    private $status = "EN COURS";

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(["com:r:a","com:r:s","com:write","L:r:simple","L:r:all"])] 
    private $gestionnaire;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["com:r:a","com:r:s","com:write","read:simple","read:all"])]
    private $client;

    #[ORM\ManyToOne(targetEntity: Livreur::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(["com:r:a","com:r:s","com:write","read:simple","read:all","client:r:a",])]
    private $livreur;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'commandes')]
    #[Groups(["com:r:a","com:r:s","com:write",])]
    private $zone;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["com:r:a","com:r:s","read:simple","read:all","client:r:a",])]
    private $createAt;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: LigneDeCommande::class, cascade:['persist'])]
    #[Groups(["com:r:a","com:r:s","com:write",])]
    #[MaxDepth(4)]
    private $ligneDeCommandes;


    public function __construct()
    {
        $this->ligneDeCommandes = new ArrayCollection();
        $this->createAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrixTotal(): ?int
    {
        return $this->prixTotal;
    }

    public function setPrixTotal(int $prixTotal): self
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

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

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * @return Collection<int, LigneDeCommande>
     */
    public function getLigneDeCommandes(): Collection
    {
        return $this->ligneDeCommandes;
    }

    public function addLigneDeCommande(LigneDeCommande $ligneDeCommande): self
    {
        if (!$this->ligneDeCommandes->contains($ligneDeCommande)) {
            $this->ligneDeCommandes[] = $ligneDeCommande;
            $ligneDeCommande->setCommande($this);
        }

        return $this;
    }

    public function removeLigneDeCommande(LigneDeCommande $ligneDeCommande): self
    {
        if ($this->ligneDeCommandes->removeElement($ligneDeCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneDeCommande->getCommande() === $this) {
                $ligneDeCommande->setCommande(null);
            }
        }

        return $this;
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

}
