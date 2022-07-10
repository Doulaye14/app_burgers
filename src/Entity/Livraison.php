<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\MongoDbOdm\ItemDataProvider;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            "status"=>Response::HTTP_OK,
            "normalization_context"=>["groups"=>["read:simple"]],
        ],
        "post"=>[
            "security"=>"is_granted('ROLE_GESTIONNAIRE')",
            "security_message"=>"Vous n'avez accès à cette ressource !",
            "denormalization_context" => ["groups" => ["L:write"]]
        ]
    ],
    itemOperations:[
        "get"=>[
            "security"=>"is_granted('ROLE_GESTIONNAIRE')",
            "security_message"=>"Vous n'avez accès à cette ressource !",
            "normalization_context"=>["groups"=>["read:all"]],
        ],
        "put"=>[
            "security"=>"is_granted('ROLE_GESTIONNAIRE')",
            "security_message"=>"Vous n'avez accès à cette ressource !"
        ]
    ]

)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["read:all"])]
    private $id;

    #[ORM\ManyToOne(targetEntity: Livreur::class, inversedBy: 'livraisons')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["read:simple","read:all","L:write"])]
    private $livreur;

    #[ORM\OneToMany(mappedBy: 'livraison', targetEntity: Commande::class)]
    #[Groups(["read:simple","read:all","L:write"])]
    private $commandes;

    #[ORM\ManyToMany(targetEntity: Zone::class, inversedBy: 'livraisons')]
    #[Groups(["read:simple","read:all","L:write"])]
    private $zones;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->zones = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setLivraison($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getLivraison() === $this) {
                $commande->setLivraison(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Zone>
     */
    public function getZones(): Collection
    {
        return $this->zones;
    }

    public function addZone(Zone $zone): self
    {
        if (!$this->zones->contains($zone)) {
            $this->zones[] = $zone;
        }

        return $this;
    }

    public function removeZone(Zone $zone): self
    {
        $this->zones->removeElement($zone);

        return $this;
    }
}
