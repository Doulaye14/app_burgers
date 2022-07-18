<?php
namespace App\DataPersister;

use App\Entity\Menus;
use App\Services\ServicePrix;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

class MenusPersister implements DataPersisterInterface
{
    private EntityManagerInterface $entityManager;
    private ServicePrix $prixMenus;

    public function __construct(EntityManagerInterface $entityManager, ServicePrix $prixMenus)
    {
        $this->entityManager = $entityManager;
        $this->prixMenus = $prixMenus;
    }

    public function supports($data) : bool
    {
        return $data instanceof Menus;
    }

    public function persist($data){
        if ($this->prixMenus->getPrixMenus($data)) {
            // $data->setPrix($this->prixMenus->getPrixMenus($data));
            // $data->eraseCredentials();
        }
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }

}