<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Controller\MenusController;
use App\Repository\MenusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: MenusRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            "status" => Response::HTTP_OK,
            "normalization_context" => ["groups" => "M:r:simple"]
        ],
        "post" =>[
            "denormalization_context"=>["groups"=>["M:write"]],
            "normalization_context" =>["groups" => ["M:p:r:all"]]
        ],
        "post_menus" =>[
            "method" => "post",
            "path" => "/menus2",
            "deserialize"=>false,
            "controller" => MenusController::class
        ]
    ],
    itemOperations:[
        "get" => [
            "normalization_context" => ["groups" => "M:r:all"]
        ],
        "put"
    ]
)]
class Menus extends Produit
{
    #[Groups(["M:r:simple","M:r:all","M:write","M:p:r:all"])]
    protected $nom;

    #[Groups(["M:r:simple","M:r:all","M:write",])]
    protected $image;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenusBurger::class, cascade:['persist'])]
    #[Groups(["M:r:all","M:write","M:p:r:all"])]
    #[ApiSubresource]
    #[SerializedName('Burgers')]
    private $menusBurgers;

    #[ORM\OneToMany(mappedBy: 'menus', targetEntity: MenusProtionFrites::class, cascade:['persist'])]
    #[Groups(["M:r:all","M:write","M:p:r:all"])]
    #[ApiSubresource]
    #[SerializedName('Frites')]
    private $menusPortionFrites;

    #[ORM\OneToMany(mappedBy: 'menus', targetEntity: MenusTailleBoisson::class, cascade:['persist'])]
    #[Groups(["M:r:all","M:write","M:p:r:all"])]
    #[ApiSubresource]
    #[SerializedName('Boissons')]
    private $menusTailleBoissons;

    #[Groups(["M:r:simple","M:r:all","M:p:r:all"])]
    private float $prix;

    public function __construct()
    {
        $this->menusBurgers = new ArrayCollection();
        $this->menusPortionFrites = new ArrayCollection();
        $this->menusTailleBoissons = new ArrayCollection();
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
            $menusBurger->setMenu($this);
        }

        return $this;
    }

    public function removeMenusBurger(MenusBurger $menusBurger): self
    {
        if ($this->menusBurgers->removeElement($menusBurger)) {
            // set the owning side to null (unless already changed)
            if ($menusBurger->getMenu() === $this) {
                $menusBurger->setMenu(null);
            }
        }

        return $this;
    }

    public function addBurger(Burger $burger, int $qnt=1){
        $menuB = new MenusBurger();
        $menuB->setBurger($burger)
              ->setQuantity($qnt)
              ->setMenu($this);
    }

    public function addTabBurgers(array $tabBurgers){
        $menuB = new MenusBurger();
        foreach($tabBurgers as $burger){
            $this->addBurger($burger);
        }
        $this->addMenusBurger($menuB);
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
            $menusPortionFrite->setMenus($this);
        }

        return $this;
    }

    public function removeMenusPortionFrite(MenusProtionFrites $menusPortionFrite): self
    {
        if ($this->menusPortionFrites->removeElement($menusPortionFrite)) {
            // set the owning side to null (unless already changed)
            if ($menusPortionFrite->getMenus() === $this) {
                $menusPortionFrite->setMenus(null);
            }
        }

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
            $menusTailleBoisson->setMenus($this);
        }

        return $this;
    }

    public function removeMenusTailleBoisson(MenusTailleBoisson $menusTailleBoisson): self
    {
        if ($this->menusTailleBoissons->removeElement($menusTailleBoisson)) {
            // set the owning side to null (unless already changed)
            if ($menusTailleBoisson->getMenus() === $this) {
                $menusTailleBoisson->setMenus(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of prix
     */ 
    public function getPrix()
    {
        return $this->prix;
    }
    
    /**
     * Set the value of prix
     *
     * @return  self
     */ 
    public function setPrix($prix)
    {
        $this->prix = $prix;
        return $this;
    }
}
