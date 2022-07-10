<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ZoneRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ZoneRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            "status" => Response::HTTP_OK,
            "normalization_context" => ["groups"=>["read:simple"]],
        ],
        "post"=>[
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas accès à cette ressouce !",
            "denormalization_context" => ["groups"=>["write"]]
        ]
    ],
    itemOperations:[
        "get"=>[
            "normalization_context" => ["groups"=>["read:all"]],
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas accès à cette ressouce !",
        ],
        "put"=>[
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas accès à cette ressouce !"
        ]
    ]
)]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["read:all","Q:r:all","Q:write","Q:r:p"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["read:simple","read:all","write","Q:r:p"])]
    private $nom;

    #[ORM\Column(type: 'float')]
    #[Groups(["read:simple","read:all","write"])]
    private $prixLivraison;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Quartier::class)]
    #[ApiSubresource]
    #[Groups(["read:all"])]
    private $quartiers;

    #[ORM\ManyToMany(targetEntity: Livraison::class, mappedBy: 'zones')]
    private $livraisons;

    public function __construct()
    {
        $this->quartiers = new ArrayCollection();
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

    public function getPrixLivraison(): ?float
    {
        return $this->prixLivraison;
    }

    public function setPrixLivraison(float $prixLivraison): self
    {
        $this->prixLivraison = $prixLivraison;

        return $this;
    }

    /**
     * @return Collection<int, Quartier>
     */
    public function getQuartiers(): Collection
    {
        return $this->quartiers;
    }

    public function addQuartier(Quartier $quartier): self
    {
        if (!$this->quartiers->contains($quartier)) {
            $this->quartiers[] = $quartier;
            $quartier->setZone($this);
        }

        return $this;
    }

    public function removeQuartier(Quartier $quartier): self
    {
        if ($this->quartiers->removeElement($quartier)) {
            // set the owning side to null (unless already changed)
            if ($quartier->getZone() === $this) {
                $quartier->setZone(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Livraison>
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons[] = $livraison;
            $livraison->addZone($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            $livraison->removeZone($this);
        }

        return $this;
    }
}
