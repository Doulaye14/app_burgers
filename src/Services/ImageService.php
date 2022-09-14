<?php

namespace App\Services;
use App\Entity\Boisson;
use App\Entity\Produit;


class ImageService
{
	function insertImage(Produit $product){
		if ($product instanceof Boisson) {
			foreach ($product->getTailleBoissons() as $tailleBoisson) {
				$tailleBoisson->setImage(file_get_contents($tailleBoisson->getPlaineImage()));
				$tailleBoisson->setBoisson($product);
			}
		}
	}
}
