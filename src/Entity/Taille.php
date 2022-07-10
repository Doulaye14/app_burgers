<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TailleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TailleRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[

        ],
        "post"=>[
            "denormalization_context" => ["groups" => ["T:write"]]
        ]
    ]
)]
class Taille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["M:r:all","M:write","write"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["T:write"])]
    private $libelle;

    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: TailleBoisson::class)]
    private $tailleBoissons;

    #[ORM\Column(type: 'float')]
    #[Groups(["T:write"])]
    private $prix;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $QuantityStok;

    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: MenusTailleBoisson::class)]
    private $menusTailleBoissons;

    public function __construct()
    {
        $this->tailleBoissons = new ArrayCollection();
        $this->menusTailleBoissons = new ArrayCollection();
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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQuantityStok(): ?int
    {
        return $this->QuantityStok;
    }

    public function setQuantityStok(int $QuantityStok): self
    {
        $this->QuantityStok = $QuantityStok;

        return $this;
    }

    /**
     * @return Collection<int, MenusTailleBoisson>
     */
    public function getMenusTailleBoissons(): Collection
    {
        return $this->menusTailleBoissons;
    }

    public function addMenusTailleBoisson(MenusTailleBoisson $menusTailleBoisson): self
    {
        if (!$this->menusTailleBoissons->contains($menusTailleBoisson)) {
            $this->menusTailleBoissons[] = $menusTailleBoisson;
            $menusTailleBoisson->setTaille($this);
        }

        return $this;
    }

    public function removeMenusTailleBoisson(MenusTailleBoisson $menusTailleBoisson): self
    {
        if ($this->menusTailleBoissons->removeElement($menusTailleBoisson)) {
            // set the owning side to null (unless already changed)
            if ($menusTailleBoisson->getTaille() === $this) {
                $menusTailleBoisson->setTaille(null);
            }
        }

        return $this;
    }
}
