<?php

namespace App\DataProvider;

use App\Entity\Catalogue;
use App\Repository\MenusRepository;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

class CatalogueDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface{
    
    public function __construct(MenusRepository $menusRepo, BurgerRepository $burgerRepo)
        {
            $this->menusRepo = $menusRepo;
            $this->burgerRepo = $burgerRepo;
        }
    
    /**
     * []
     */
    public function getCollection(string $resourceClass, string $operationName = null, array $context = []){
        return $context = [$this->menusRepo->findAll(),$this->burgerRepo->findAll() ];
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool{
        return $resourceClass == Catalogue::class;
    }
}