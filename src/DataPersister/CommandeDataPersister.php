<?php

namespace App\DataPersister;

use App\Entity\Commande;
use App\Services\ServicePrix;
use Doctrine\ORM\EntityManager;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\LigneDeCommande;
use Doctrine\ORM\EntityManagerInterface;

class CommandeDataPersister implements DataPersisterInterface
{
    private EntityManagerInterface $entityManager;
    private ServicePrix $service;

    public function __construct(EntityManagerInterface $entityManager, ServicePrix $service)
    {
        $this->entityManager = $entityManager;
        $this->service = $service;
    }

    public function supports($data): bool
    {
        return $data instanceof Commande;
    }

    public function persist($data){
        if ($this->service->prixCommande($data)) {
            $data->setPrixTotal($this->service->prixCommande($data));
            $data->eraseCredentials();
        }
        $ligneDeCommande = new LigneDeCommande();
        $ligneDeCommande->setCommande($data);
        $ligneDeCommande->setPrix($ligneDeCommande->getPrix()*$ligneDeCommande->getQuantity());
        // $this->entityManager->persist($ligneDeCommande);
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data){
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }


}