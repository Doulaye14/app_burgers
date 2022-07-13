<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints\Date;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            "status"=> Response::HTTP_OK,
            "normalization_context"=>["groups" => ["c:r:simple"]],
        ],
        "post"=>[
            "denormalization_context"=>["groups" => ["c:write"]],
            "security" => "is_granted('ROLE_CLIENT')",
            "message_security" => "Vous n'avez le droit !"
        ]
    ],
    itemOperations:[
        "get"=>[
            "status"=> Response::HTTP_OK,
            "normalization_context"=>["groups" => "c:r:all"]
        ],
        "put"=>[
            
        ]
    ]
)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["c:r:all"])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(["c:r:all","c:r:simple"])]
    private $prixTotal;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["c:r:all","c:r:simple"])]
    private $status = "EN COURS";

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(["c:r:all","c:r:simple"])]
    private $livraison;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(["c:r:all","c:r:simple"])]    
    private $gestionnaire;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["c:r:all","c:r:simple"])]
    private $client;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: LigneDeCommande::class, cascade:['persist'])]
    #[Groups(["c:r:all","c:r:simple","c:write"])]
    #[SerializedName("Produits")]
    private $ligneDeCommandes;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'commandes')]
    #[Groups(["c:r:all","c:r:simple","c:write"])]
    private $zone;

    #[ORM\Column(type: 'date')]
    #[Groups(["c:r:all","c:r:simple","c:write"])]
    private $createAt;

    public function __construct()
    {
        $this->ligneDeCommandes = new ArrayCollection();
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

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

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

}
