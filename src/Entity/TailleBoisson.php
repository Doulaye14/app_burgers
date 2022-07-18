<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleBoissonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TailleBoissonRepository::class)]
#[ApiResource]
class TailleBoisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups([
        "read:simple","read:all","write",
        "c:r:all","c:r:simple","c:write",
        "M:r:all","M:write"
    ])]
    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(["read:simple","read:all","write"])]
    private $quantity;

    #[ORM\Column(type: 'float')]
    #[Groups(["read:simple","read:all","write"])]
    private $prix;

    #[ORM\ManyToOne(targetEntity: Boisson::class, inversedBy: 'tailleBoissons')]
    #[ORM\JoinColumn(nullable: false)]
    private $boisson;

    #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'tailleBoissons')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["read:simple","read:all","write"])]
    private $taille;

    #[ORM\OneToMany(mappedBy: 'tailleBoisson', targetEntity: LigneTaille::class)]
    private $ligneTailles;

    public function __construct()
    {
        $this->ligneTailles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

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

    public function getBoisson(): ?Boisson
    {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): self
    {
        $this->boisson = $boisson;

        return $this;
    }

    public function getTaille(): ?Taille
    {
        return $this->taille;
    }

    public function setTaille(?Taille $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    /**
     * @return Collection<int, LigneTaille>
     */
    public function getLigneTailles(): Collection
    {
        return $this->ligneTailles;
    }

    public function addLigneTaille(LigneTaille $ligneTaille): self
    {
        if (!$this->ligneTailles->contains($ligneTaille)) {
            $this->ligneTailles[] = $ligneTaille;
            $ligneTaille->setTailleBoisson($this);
        }

        return $this;
    }

    public function removeLigneTaille(LigneTaille $ligneTaille): self
    {
        if ($this->ligneTailles->removeElement($ligneTaille)) {
            // set the owning side to null (unless already changed)
            if ($ligneTaille->getTailleBoisson() === $this) {
                $ligneTaille->setTailleBoisson(null);
            }
        }

        return $this;
    }
}
