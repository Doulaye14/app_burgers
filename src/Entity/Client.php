<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(
    collectionOperations:
    [
        "get" => [
            "status" => Response::HTTP_OK,
            "normalization_context" => ["groups" => ["C:read:simple"]],
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "securi_message" => "Vous n'avez pas accès à cette ressource"
        ],
        "post_register"=>[
            "method" => "post",
            "path" => "/register/client",
            "denormalization_context" => ["groups" => ["C:write"]]
        ]
    ],
    itemOperations:
    [
        "get" => [
            "status" => Response::HTTP_OK,
            "normalization_context" => ["groups" => ["C:read:all"]]
        ],
        "put" => [

        ]
    ]
)]
class Client extends User
{

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["C:read:simple","C:write","C:read:all"])]
    private $phone;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Commande::class)]
    #[Groups(["C:read:all"])]
    private $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

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
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }
}

