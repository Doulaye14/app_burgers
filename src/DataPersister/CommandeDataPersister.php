<?php

namespace App\DataPersister;

use App\Entity\Commande;
use App\Services\ServicePrix;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\LigneDeCommande;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\Date;

class CommandeDataPersister implements DataPersisterInterface
{
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepo;
    private ServicePrix $service;

    public function __construct(EntityManagerInterface $entityManager, ServicePrix $service, UserRepository $userRepo)
    {
        $this->entityManager = $entityManager;
        $this->service = $service;
        $this->userRepo = $userRepo;
    }

    public function supports($data): bool
    {
        return $data instanceof Commande;
    }

    public function persist($data){
        $prixCom = 0;
        foreach ($data->getLigneDeCommandes() as $ligneCom) {
            $ligneCom->setPrix($ligneCom->getProduit()->getPrix()*$ligneCom->getQuantity());
            $prixCom += $ligneCom->getPrix();
        }
        if ($data->getZone()) {
            $prixCom += $data->getZone()->getPrixLivraison();
        }
        $data->setPrixTotal($prixCom);
        // $data->setCreateAt();
        // $data->setClient($this->userRepo->find(1));
        // dd($data);
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data){
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}
