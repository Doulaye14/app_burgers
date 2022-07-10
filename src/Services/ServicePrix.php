<?php

namespace App\Services;

use App\Entity\Menus;
use App\Entity\Burger;
use App\Entity\Boisson;
use App\Entity\Commande;
use App\Entity\PortionFrites;
use App\Repository\BurgerRepository;
use App\Repository\BoissonRepository;
use App\Repository\PortionFritesRepository;

class ServicePrix {
    
    /**
     * Calcul du prix d'un Menus en faisant la somme 
     * des prix des burgers et complements qui le compose !
     */
    private BurgerRepository $burgerRepo;
    private BoissonRepository $boissonRepo;
    private PortionFritesRepository $portionRepo;
    public function __construct(
        BurgerRepository $burgerRepo, 
        BoissonRepository $boissonRepo,
        PortionFritesRepository $portionRepo
        )
    {
        $this->burgerRepo = $burgerRepo;
        $this->boissonRepo = $boissonRepo;
        $this->portionRepo = $portionRepo;
    }
    public function getPrixMenus(Menus $menus)
    {
        $prix = 0;
        foreach ($menus->getMenusBurgers() as $menusBurger) {
            $prix += $menusBurger->getBurger()->getPrix()*
                     $menusBurger->getQuantity();
        }
        foreach ($menus->getMenusPortionFrites() as $menusPortion) {
            $prix += $menusPortion->getPortionFrites()->getPrix()*
                     $menusPortion->getQuantity();
        }
        foreach ($menus->getMenusTailleBoissons() as $menusTaille) {
            $prix += $menusTaille->getTaille()->getPrix()*
                     $menusTaille->getQuantity();
        }
        return $prix;
    }

    /**
     * Calcul du prix d'une commande en 
     * sommant les prix des lignes de commande
     */
    public function prixCommande(Commande $commande){
        $prix = 0;
        foreach ($commande->getLigneDeCommandes() as $ligneDeCom) {
            $produit = $ligneDeCom->getProduit();
            if ($produit instanceof Menus) {
                $prix += $this->getPrixMenus($produit)*$ligneDeCom->getQuantity();
            }
            dd($prix);
            if ($produit instanceof Burger) {
                $burger = $this->burgerRepo->find($produit->getId());
                $prix += $burger->getPrix()*$ligneDeCom->getQuantity(); 
            }
            if($produit instanceof PortionFrites){
                $frites = $this->portionRepo->find($produit->getId());
                $prix += $frites->getPrix()*$ligneDeCom->getQuantity();
            }
            if ($produit instanceof Boisson) {
                $boisson = $this->boissonRepo->find($produit->getId());
                foreach ($boisson->getTailleBoissons() as $tailleBoisson) {
                    
                }
            }
        }
    
    }

}
