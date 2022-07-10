<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GestionnaireRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GestionnaireRepository::class)]
#[ApiResource(
    collectionOperations:
    [
        "get" => [
            "status" => Response::HTTP_OK,
            "normalization_context" => ["groups" => ["read:simple"]],
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas accès à cette ressource"
        ],
        "post"=>[
            "path" => "/register/gestionnaire",
            "denormalization_context" => ["groups" => ["write"]],
            "normalization_context" => ["groups" => ["u:r:all"]],
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas accès à cette ressource"
        ]
    ],
    itemOperations:
    [
        "get" => [
            "status" => Response::HTTP_OK,
            "normalization_context" => ["groups" => ["read:all"]]
        ],
        "put" => [
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas accès à cette ressource"
        ]
    ]
)]
class Gestionnaire extends User
{
    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Commande::class)]
    #[ApiSubresource]
    #[Groups(["read:all"])]
    private $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->roles [] = "ROLE_GESTIONNAIRE";
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
            $commande->setGestionnaire($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getGestionnaire() === $this) {
                $commande->setGestionnaire(null);
            }
        }

        return $this;
    }
}
