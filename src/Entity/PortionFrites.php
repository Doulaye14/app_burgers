<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PortionFritesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    collectionOperations:[
        'get',
        'post'=>[
            'denormalization_context' => ['groups' => ['por:write']],

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
