<?php

namespace App\DataFixtures;

use App\Entity\Gestionnaire;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class GestionnaireFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        $gestionnaire = new Gestionnaire();
        $pass = $this->hasher->hashPassword($gestionnaire, "passer");
        $gestionnaire->setPrenom("Abdoulaye")
                     ->setNom("Mangane")
                     ->setEmail("mangane@gmail.com")
                     ->setPassword($pass)
                     ->setRoles(["ROLE_GESTIONNAIRE"]);

        $manager->persist($gestionnaire);
        $manager->flush();
    }
}
