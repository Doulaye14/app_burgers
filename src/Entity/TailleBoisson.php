<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleBoissonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: TailleBoissonRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            "status" => Response::HTTP_OK,
            "normalization_context" => ["groups" => ["tb:r:s"]]
        ],
        "post"
    ],
    itemOperations:[
        "get"=>[
            "status" => Response::HTTP_OK,
            "normalization_context" => ["groups" => ["tb:r:a"]]
        ],
        "put"
    ]
)]
class TailleBoisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["produit:r:a","boisson:w","com:write","tb:r:s","tb:r:a",])]
    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(["produit:r:a","boisson:w","tb:r:s","tb:r:a"])]
    private $quantity;

    #[ORM\Column(type: 'float')]
    #[Groups(["produit:r:a","boisson:w","com:r:a","com:r:s","tb:r:s","tb:r:a"])]
    private $prix;

    #[ORM\ManyToOne(targetEntity: Boisson::class, inversedBy: 'tailleBoissons')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["produit:r:a","boisson:w","tb:r:s","tb:r:a"])]
    private $boisson;

    #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'tailleBoissons')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["boisson:w","tb:r:s","tb:r:a"])]
    private $taille;

    #[ORM\OneToMany(mappedBy: 'tailleBoisson', targetEntity: LigneTaille::class)]
    private $ligneTailles;

    #[ORM\Column(type: 'blob', nullable: true)]
    #[Groups(["produit:r:a","com:r:a","com:r:s","tb:r:s","tb:r:a"])]
    private $image;

    #[Groups(["boisson:w"])]
    #[SerializedName('image')]
    private $plaineImage;

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

    public function getImage():? string
    {
        return (is_resource($this->image)?utf8_encode(base64_encode(stream_get_contents($this->image))):$this->image);
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of plaineImage
     */ 
    public function getPlaineImage()
    {
        return $this->plaineImage;
    }

    /**
     * Set the value of plaineImage
     *
     * @return  self
     */ 
    public function setPlaineImage($plaineImage)
    {
        $this->plaineImage = $plaineImage;

        return $this;
    }
}
