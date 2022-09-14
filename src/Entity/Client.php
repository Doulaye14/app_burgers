<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(
    collectionOperations:
    [
        "get" => [
            "status" => Response::HTTP_OK,
            "normalization_context" => ["groups" => ["client:r:s"]],
            // "security" => "is_granted('ROLE_GESTIONNAIRE')",
            // "securi_message" => "Vous n'avez pas accès à cette ressource"
        ],
        "post_register"=>[
            "method" => "post",
            "path" => "/register/client",
            "denormalization_context" => ["groups" => ["client:w"]],
            "normalization_context" => ["groups" => ["client:r:a"]]
        ]
    ],
    itemOperations:
    [
        "get" => [
            "status" => Response::HTTP_OK,
            "normalization_context" => ["groups" => ["client:r:a"]],
            // "security"=>"is_granted('ROLE_GESTIONNAIRE')",
            // "security_message"=>"Vous n'avez pas accès à cette ressouce !"
        ],
        "put" => [
            "denormalization_context" => ["groups" => ["client:w"]]
            // "security"=>"is_granted('ROLE_GESTIONNAIRE')",
            // "security_message"=>"Vous n'avez pas accès à cette ressouce !"
        ]
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['email' => 'exact',])]
class Client extends User
{

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["read:simple","write","read:all","client:r:s","client:r:a","client:w","com:r:a","com:r:s","com:update","user:r:s","L:r:all"])]
    private $phone;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Commande::class)]
    #[Groups(["read:all","client:r:s","client:r:a","user:r:s"])]
    #[ApiSubresource()]
    private $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->roles [] = "ROLE_CLIENT";
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
