<?php

namespace App\Services;

use App\Entity\Menus;
use App\Entity\Burger;
use App\Entity\Commande;
use App\Repository\BurgerRepository;


class ServicePrix {


    private BurgerRepository $burgerRepo;

    
    public function __construct(BurgerRepository $burgerRepo)
    {
        $this->burgerRepo = $burgerRepo;
    }
    /**
     * Calcul du prix d'un Menus en faisant la somme 
     * des prix des burgers et complements qui le compose !
     */
   
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
        foreach ($menus->getMenusTailles() as $menusTaille) {
            $prix += $menusTaille->getTaille()->getPrix()*
                     $menusTaille->getQuantity();
        }
        return $prix;
    }

    // public function getPrixCommande(Commande $commande){
    //     $prix = 0;
    //     foreach ($commande->getLigneDeCommandes() as $ligneCom) {
    //         $produit = $ligneCom->getProduit();
    //         dd($produit);
    //         if ($produit instanceof Burger) {
    //             $burger = $this->burgerRepo->find($produit->getId());
    //             $prix += $burger->getPrix()*$ligneCom->getQuantity();
    //         }
    //     }
    //     return $prix;
    // }

}
