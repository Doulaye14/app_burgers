<?php

namespace App\EventSubscriber;

use App\Entity\Menus;
use App\Entity\Burger;
use App\Entity\Frites;
use App\Entity\Boisson;
use App\Entity\Commande;
use App\Entity\PortionFrites;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class GestionnaireSubscriber implements EventSubscriberInterface
{
    private ?TokenInterface $token;
    
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->token = $tokenStorage->getToken();
    }

    public static function getSubscribedEvents(): array
    {
        return [Events::prePersist];
    }
    
    public function getUser()
    {
        //dd($this->token);
        if (null === $token = $this->token) {
            return null;
        }
        if (!is_object($user = $token->getUser())) {
        // e.g. anonymous authentication
            return null;
        }
        return $user;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        if (
            ($args->getObject() instanceof Burger) or 
            ($args->getObject() instanceof Menus) or 
            ($args->getObject() instanceof PortionFrites) or
            ($args->getObject() instanceof Boisson)
        ){
            $args->getObject()->setUser($this->getUser());
        }elseif($args->getObject() instanceof Commande){
            $args->getObject()->setClient($this->getUser());
        }
    }
    
}
