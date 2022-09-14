<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TailleRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            "status"=>Response::HTTP_OK,
            "normalization_context" => ["groups" => ["T:r:simple"]]
        ],
        "post"=>[
            "denormalization_context" => ["groups"=>["T:write"]],
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas accès à cette ressource"
        ]
    ],
    itemOperations:[
        "get"=>[
            "normalization_context" => ["groups" => ["T:r:all"]],
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas accès à cette ressource"
        ],
        "put"=>[
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas accès à cette ressource"
        ]
    ]
)]
class Taille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["Menus:w","produit:r:a","boisson:w"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["produit:r:a"])]
    private $libelle;

    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: TailleBoisson::class)]
    #[Groups(["produit:r:a"])]
    private $tailleBoissons;

    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: MenusTaille::class)]
    private $menusTailles;

    public function __construct()
    {
        $this->tailleBoissons = new ArrayCollection();
        $this->menusTailles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
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
            $tailleBoisson->setTaille($this);
        }

        return $this;
    }

    public function removeTailleBoisson(TailleBoisson $tailleBoisson): self
    {
        if ($this->tailleBoissons->removeElement($tailleBoisson)) {
            // set the owning side to null (unless already changed)
            if ($tailleBoisson->getTaille() === $this) {
                $tailleBoisson->setTaille(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenusTaille>
     */
    public function getMenusTailles(): Collection
    {
        return $this->menusTailles;
    }

    public function addMenusTaille(MenusTaille $menusTaille): self
    {
        if (!$this->menusTailles->contains($menusTaille)) {
            $this->menusTailles[] = $menusTaille;
            $menusTaille->setTaille($this);
        }

        return $this;
    }

    public function removeMenusTaille(MenusTaille $menusTaille): self
    {
        if ($this->menusTailles->removeElement($menusTaille)) {
            // set the owning side to null (unless already changed)
            if ($menusTaille->getTaille() === $this) {
                $menusTaille->setTaille(null);
            }
        }

        return $this;
    }
}
