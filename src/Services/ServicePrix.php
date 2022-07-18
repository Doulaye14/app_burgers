<?php

namespace App\Services;

use App\Entity\Menus;
use App\Entity\Burger;
use App\Entity\Boisson;
use App\Entity\Commande;
use App\Entity\PortionFrites;


class ServicePrix {

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
        return $prix;
    }

    /**
     * Calcul du prix d'une commande
     */

    public function getPrixCommande(Commande $commande){
        $prix = 0;
        foreach ($commande->getLigneDeCommandes() as $ligneCom) {
            $produit = $ligneCom->getProduit();
            if ($produit instanceof Menus) {
                $tailles = $produit->getMenusTailles();
                foreach ($tailles as $taille) {
                    $tailleB = $taille->getTaille();
                    foreach ($ligneCom->getLigneTailles() as $ligneTaille) {
                        $tail = $ligneTaille->getTailleBoisson()->getTaille();
                        if ($tailleB->getId() == $tail->getId()) {
                            $prix += 
                                ($this->getPrixMenus($produit)+
                                $ligneTaille->getTailleBoisson()->getPrix()*
                                $ligneTaille->getQuantity())*
                                $ligneCom->getQuantity();
                        }else{
                            echo $produit->getNom()." n'a pas une boisson de taille ".$tail->getLibelle();
                        }
                    }
                }
            }
            if ($produit instanceof Boisson) {
                foreach ($produit->getTailleBoissons() as $tailleBoisson) {
                    $taille = $tailleBoisson->getTaille();
                    foreach ($ligneCom->getLigneTailles() as $ligneTaille) {
                        $tail = $ligneTaille->getTailleBoisson()->getTaille();
                        if ($taille->getId() == $tail->getId()) {
                            $prix += $ligneTaille->getTailleBoisson()->getPrix()*
                                     $ligneTaille->getQuantity();
                        }else {
                            echo "la boisson ".$produit->getNom()." n'a pas la taille ".$tail->getLibelle();
                        }
                    }
                }
            }
            if (($produit instanceof Burger) || ($produit instanceof PortionFrites) ) {
                $prix += $produit->getPrix()*$ligneCom->getQuantity();
            }
        }
        if($commande->getZone()){
            $prix += $commande->getZone()->getPrixLivraison();
        }
        return $prix;
    }

}
