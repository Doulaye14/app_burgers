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

    #[ORM\Column(type: 'float')]
    #[Groups(["T:write"])]
    private $prix;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $QuantityStok;

    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: MenusTaille::class)]
    private $menusTailles;

    #[ORM\ManyToMany(targetEntity: Boisson::class, inversedBy: 'tailles')]
    private $boissons;

    public function __construct()
    {
        $this->menusTailles = new ArrayCollection();
        $this->boissons = new ArrayCollection();
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

    /**
     * @return Collection<int, Boisson>
     */
    public function getBoissons(): Collection
    {
        return $this->boissons;
    }

    public function addBoisson(Boisson $boisson): self
    {
        if (!$this->boissons->contains($boisson)) {
            $this->boissons[] = $boisson;
        }

        return $this;
    }

    public function removeBoisson(Boisson $boisson): self
    {
        $this->boissons->removeElement($boisson);

        return $this;
    }
}
