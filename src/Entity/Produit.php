<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]

#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"type",type:"string")]
#[ORM\DiscriminatorMap(["burger"=>"Burger","menus"=>"Menus","portionfrites"=>"PortionFrites","boisson"=>"Boisson"])]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            "status" => Response::HTTP_OK,
            "normalization_context" => ["groups" => "produit:r:s"]
        ],
        "post"=>[
            'denormalization_context'=>["groups" => "produit:w"]
        ]
    ],
    itemOperations:[
        "get" => [
            "status"=>Response::HTTP_OK,
            "normalization_context" => ["groups" => "produit:r:a"]
        ],
    ]
)]

class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(
        [
            "Menus:w","com:r:a","com:write",
            "produit:w","com:update",
            "produit:r:s","produit:r:a",
            "Menus:r:a","Menus:r:s",
            'burger:r:a','burger:r:s',
            "tb:r:s","tb:r:a","client:r:a"
        ]
    )]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(
        [
            "burger:w","portion:w","boisson:w",
            "produit:r:s","produit:r:a",
            'burger:r:a','burger:r:s',
            'Menus:r:s','Menus:r:a',
            "com:r:a","com:r:s","com:update",
            "tb:r:s","tb:r:a","client:r:a"
        ]
    )]
    protected $nom;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["Menus:w","produit:w"])]
    protected $user;
    
    #[Groups(["burger:w","portion:w","boisson:w"])]
    #[SerializedName("image")]
    protected $plaineImage;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups(
        [
            "burger:w","portion:w","com:update",
            "produit:r:s","produit:r:a",
            "Menus:r:s","Menus:r:a",
            'burger:r:a','burger:r:s',
            "com:r:a","com:r:s","client:r:a"

        ]
    )]
    protected $prix;

    #[ORM\ManyToOne(targetEntity: Type::class, inversedBy: 'produits')]
    private $type;


    #[ORM\Column(type: 'blob', nullable: true)]
    #[Groups(
        [
            "produit:r:s","produit:r:a",
            "Menus:r:s","Menus:r:a",
            'burger:r:a','burger:r:s',
            "client:r:a",
        ]
    )]
    protected $image;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: LigneDeCommande::class)]
    protected $ligneDeCommandes;

    #[ORM\Column(type: 'boolean')]
    #[Groups(["prod:r:all"])]
    private $isEtat = true;

    public function __construct()
    {
        $this->ligneDeCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getImage(): ?string
    {
        return (is_resource($this->image)?(base64_encode(stream_get_contents($this->image))):$this->image); 
    }

    public function setImage($image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    // /**
    //  * @return Collection|null <int, LigneDeCommande>
    //  */
    // public function getLigneDeCommandes():? Collection
    // {
    //     return $this->ligneDeCommandes;
    // }

    public function addLigneDeCommande(LigneDeCommande $ligneDeCommande): self
    {
        if (!$this->ligneDeCommandes->contains($ligneDeCommande)) {
            $this->ligneDeCommandes[] = $ligneDeCommande;
            $ligneDeCommande->setProduit($this);
        }

        return $this;
    }

    public function removeLigneDeCommande(LigneDeCommande $ligneDeCommande): self
    {
        if ($this->ligneDeCommandes->removeElement($ligneDeCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneDeCommande->getProduit() === $this) {
                $ligneDeCommande->setProduit(null);
            }
        }

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

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
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
    
}
