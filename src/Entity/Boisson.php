<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: BoissonRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            "status"=>Response::HTTP_OK,
            "normalization_context" => ["groups" => ["read:simple"]]
        ],
        "post"=>[
            "denormalization_context" => ["groups"=>["write"]],
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas accès à cette ressource"
        ]
    ],
    itemOperations:[
        "get"=>[
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas accès à cette ressource"
        ],
        "put"=>[
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas accès à cette ressource"
        ]
    ]
)]
class Boisson extends Produit
{

    #[ORM\OneToMany(mappedBy: 'boisson', targetEntity: TailleBoisson::class, cascade:['persist'])]
    #[Groups(["write"])]
    #[SerializedName("Tailles")]
    private $tailleBoissons;

    public function __construct()
    {
        parent::__construct();
        $this->tailleBoissons = new ArrayCollection();
    }

    /**
     * @return Collection<int, TailleBoisson>
     */
    public function getTailleBoissons(): Collection
    {
        return $this->tailleBoissons;
    }

    public function addTailleBoisson(TailleBoisson $tailleBoisson): self
    {
        if (!$this->tailleBoissons->contains($tailleBoisson)) {
            $this->tailleBoissons[] = $tailleBoisson;
            $tailleBoisson->setBoisson($this);
        }

        return $this;
    }

    public function removeTailleBoisson(TailleBoisson $tailleBoisson): self
    {
        if ($this->tailleBoissons->removeElement($tailleBoisson)) {
            // set the owning side to null (unless already changed)
            if ($tailleBoisson->getBoisson() === $this) {
                $tailleBoisson->setBoisson(null);
            }
        }

        return $this;
    }


}
