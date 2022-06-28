<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Livraison;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreurRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
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
            "normalization_context" => ["groups" => ["L:read:simple"]],
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "securi_message" => "Vous n'avez pas accès à cette ressource"
        ],
        "post"=>[
            "path" => "/register/livreur",
            "denormalization_context" => ["groups" => ["L:write"]]
        ]
    ],
    itemOperations:
    [
        "get" => [
            "status" => Response::HTTP_OK,
            "normalization_context" => ["groups" => ["L:read:all"]]
        ],
        "put" => [

        ]
    ]
)]
class Livreur extends User
{

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["L:read:simple","L:read:all"])]
    private $etat = "Disponible";

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["L:read:all"])]
    private $matriculeMoto;

    #[ORM\OneToMany(mappedBy: 'livreur', targetEntity: Livraison::class)]
    private $livraisons;

    public function __construct()
    {
        $this->livraisons = new ArrayCollection();
        $this->matriculeMoto = "MOTO-".date_format(new DateTime, 'i-s');
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
}
