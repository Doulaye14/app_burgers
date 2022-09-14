<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use App\Entity\User;
use App\Entity\Livraison;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreurRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivreurRepository::class)]
#[ApiResource(
    collectionOperations:
    [
        "get" => [
            "status" => Response::HTTP_OK,
            // "normalization_context" => ["groups" => ["Lvr:r:s"]],
            // "security" => "is_granted('ROLE_GESTIONNAIRE')",
            // "securi_message" => "Vous n'avez pas accès à cette ressource"
        ],
        "post"=>[
            "path" => "/register/livreur",
            "denormalization_context" => ["groups" => ["lvr:write"]]
        ]
    ],
    itemOperations:
    [
        "get" => [
            "status" => Response::HTTP_OK,
            "normalization_context" => ["groups" => ["lvr:r:a"]]
        ],
        "put" => [
            
        ]
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['email' => 'exact',])]
class Livreur extends User
{
    
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["read:simple","read:all","L:r:simple","L:r:all","user:r:s","lvr:r:a"])]
    private $etat = "Disponible";

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["L:r:simple","L:r:all","read:simple","read:all","user:r:s","lvr:r:a"])]
    private $matriculeMoto;

    #[ORM\OneToMany(mappedBy: 'livreur', targetEntity: Livraison::class)]
    #[Groups(["user:r:s","read:all","lvr:r:a"])]
    private $livraisons;

    #[ORM\OneToMany(mappedBy: 'livreur', targetEntity: Commande::class)]
    private $commandes;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["read:simple","read:all","write","L:r:simple","L:r:all","L:write","lvr:r:a"])]
    private $phone;

    public function __construct()
    {
        parent::__construct();
        $this->livraisons = new ArrayCollection();
        $this->matriculeMoto = "MOTO-".date_format(new DateTime, 'i-s');
        $this->roles [] = "ROLE_LIVREUR";
        $this->commandes = new ArrayCollection();
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getMatriculeMoto(): ?string
    {
        return $this->matriculeMoto;
    }

    public function setMatriculeMoto(string $matriculeMoto): self
    {
        $this->matriculeMoto = $matriculeMoto;

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
            $livraison->setLivreur($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getLivreur() === $this) {
                $livraison->setLivreur(null);
            }
        }

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
            $commande->setLivreur($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getLivreur() === $this) {
                $commande->setLivreur(null);
            }
        }

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
