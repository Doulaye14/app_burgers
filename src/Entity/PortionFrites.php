<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PortionFritesRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    collectionOperations:[
        "get"=>[
            "status" => Response::HTTP_OK,
            "normalization_context" => ["groups" => ["portion:r:s"]]
        ],
        "post"=>[
            "denormalization_context" => ["groups" => ["portion:w"]],
        ]
    ],
    itemOperations:[
        "get"=>[
            "status" => Response::HTTP_OK,
            "normalization_context" => ["groups" => ["portion:r:a"]]
        ],
        "put"=>[
            "denormalization_context" => ["groups" => ["portion:w"]],
        ]
    ]
)]
#[ORM\Entity(repositoryClass: PortionFritesRepository::class)]
class PortionFrites extends Produit
{

    #[ORM\OneToMany(mappedBy: 'portionFrites', targetEntity: MenusProtionFrites::class)]
    private $menusPortionFrites;

    public function __construct()
    {
        $this->menusPortionFrites = new ArrayCollection();
    }

    /**
     * @return Collection<int, MenusProtionFrites>
     */
    public function getMenusPortionFrites(): Collection
    {
        return $this->menusPortionFrites;
    }

    public function addMenusPortionFrite(MenusProtionFrites $menusPortionFrite): self
    {
        if (!$this->menusPortionFrites->contains($menusPortionFrite)) {
            $this->menusPortionFrites[] = $menusPortionFrite;
            $menusPortionFrite->setPortionFrites($this);
        }

        return $this;
    }

    public function removeMenusPortionFrite(MenusProtionFrites $menusPortionFrite): self
    {
        if ($this->menusPortionFrites->removeElement($menusPortionFrite)) {
            // set the owning side to null (unless already changed)
            if ($menusPortionFrite->getPortionFrites() === $this) {
                $menusPortionFrite->setPortionFrites(null);
            }
        }
        return $this;
    }

}
