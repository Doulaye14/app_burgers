<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource(
    collectionOperations:
    [
        "get"=>[
            'status' => Response::HTTP_OK,
            'normalization_context' => ['groups' => ['bg:r:simple']]
        ],
        "post"=>[
            'denormalization_context' => ['groups' => ['bg:write']],
            'normalization_context' => ['groups' => ['read:all']],
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas accès à cette ressource"
        ]
    ],
    itemOperations:
    [
        "get"=>[
            'status' => Response::HTTP_OK,
            'normalization_context' => ['groups' => ['bg:r:all']],
            // "security" => "is_granted('ROLE_GESTIONNAIRE')",
            // "security_message" => "Vous n'avez pas accès à cette ressource"
        ],
        "put"=>[
            'normalization_context' => ['groups' => ['bg:r:all']],
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas accès à cette ressource"
        ]
    ]
)]
class Burger extends Produit
{

    #[ORM\Column(type: 'boolean')]
    #[Groups(['bg:r:all'])]
    private $isEtat= true;

    #[ORM\OneToMany(mappedBy: 'burger', targetEntity: MenusBurger::class)]
    private $menusBurgers;
    
    public function __construct()
    {
        parent::__construct();
        $this->menuses = new ArrayCollection();
        $this->menusBurgers = new ArrayCollection();
    }

    public function isIsEtat(): ?bool
    {
        return $this->isEtat;
    }

    public function setIsEtat(bool $isEtat): self
    {
        $this->isEtat = $isEtat;

        return $this;
    }

    /**
     * @return Collection<int, MenusBurger>
     */
    public function getMenusBurgers(): Collection
    {
        return $this->menusBurgers;
    }

    public function addMenusBurger(MenusBurger $menusBurger): self
    {
        if (!$this->menusBurgers->contains($menusBurger)) {
            $this->menusBurgers[] = $menusBurger;
            $menusBurger->setBurger($this);
        }

        return $this;
    }

    public function removeMenusBurger(MenusBurger $menusBurger): self
    {
        if ($this->menusBurgers->removeElement($menusBurger)) {
            // set the owning side to null (unless already changed)
            if ($menusBurger->getBurger() === $this) {
                $menusBurger->setBurger(null);
            }
        }

        return $this;
    }
    
}
