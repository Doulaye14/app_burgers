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
    #[SerializedName("image")]
    protected $plaineImage;

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

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenusTaille::class, cascade:['persist'])]
    #[Groups(["M:r:all","M:write","M:p:r:all"])]
    #[ApiSubresource]
    #[SerializedName('Boissons')]
    private $menusTailles;

    public function __construct()
    {
        $this->menusBurgers = new ArrayCollection();
        $this->menusPortionFrites = new ArrayCollection();
        $this->menusTailles = new ArrayCollection();
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
            $menusTaille->setMenu($this);
        }

        return $this;
    }

    public function removeMenusTaille(MenusTaille $menusTaille): self
    {
        if ($this->menusTailles->removeElement($menusTaille)) {
            // set the owning side to null (unless already changed)
            if ($menusTaille->getMenu() === $this) {
                $menusTaille->setMenu(null);
            }
        }

        return $this;
    }
    
}
