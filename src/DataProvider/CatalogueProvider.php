<?php

namespace App\DataProvider;

use App\Entity\Catalogue;
use App\Repository\MenusRepository;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

class CatalogueProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface{
    
    public function __construct(MenusRepository $menusRepo, BurgerRepository $burgerRepo)
        {
            $this->menusRepo = $menusRepo;
            $this->burgerRepo = $burgerRepo;
        }
    
    /**
     * []
     */
    public function getCollection(string $resourceClass, string $operationName = null, array $context = []){
        $catalogue = [];
        $catalogue['menus'] = $this->menusRepo->findAll();
        $catalogue['bugers'] = $this->burgerRepo->findAll();
        dd($catalogue);
        return $catalogue;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool{
        return $resourceClass == Catalogue::class;
    }
}