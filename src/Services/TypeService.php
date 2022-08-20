<?php

namespace App\Services;

use App\Entity\Menus;
use App\Entity\Burger;
use App\Entity\PortionFrites;
use App\Entity\Produit;
use App\Repository\TypeRepository;

class TypeService
{

	private $typeRepo;

	function __construct(TypeRepository $typeRepo)
	{
		$this->typeRepo = $typeRepo;
	}

	function typeSetter(Produit $product){
		if ($product instanceof Burger) {
			$product->setType($this->typeRepo->find(1));
		}elseif ($product instanceof Menus) {
			$product->setType($this->typeRepo->find(2));
		}elseif ($product instanceof PortionFrites) {
			$product->setType($this->typeRepo->find(3));
		}else{
			$product->setType($this->typeRepo->find(4));
		}
	}
}
