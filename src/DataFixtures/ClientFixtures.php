<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        $client = new Client();
        $pass = $this->hasher->hashPassword($client, 'passer');

        $client->setPrenom('Adama')
               ->setNom('Ndiaye')
               ->setEmail('adama@gmail.com')
               ->setPassword($pass)
               ->setRoles(['ROLE_CLIENT'])
               ->setPhone("77 777 77 77");

        $manager->persist($client);
        $manager->flush();
    }
}
