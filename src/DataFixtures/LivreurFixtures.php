<?php

namespace App\DataFixtures;

use App\Entity\Livreur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LivreurFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        $livreur = new Livreur();

        $pass = $this->hasher->hashPassword($livreur,"passer");

        $livreur->setPrenom('Boy')
                ->setNom('Djiby')
                ->setEmail('boy@gmail.com')
                ->setPassword($pass)
                ->setRoles(['ROLE_LIVREUR'])
                ->setEtat('DISPONIBLE')
                ->setMatriculeMoto('Moto-DJB');

        $manager->persist($livreur);
        $manager->flush();
    }
}
