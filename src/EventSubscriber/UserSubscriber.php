<?php

namespace App\EventSubscriber;

use App\Entity\Menus;
use App\Entity\Burger;
use App\Entity\Boisson;
use App\Entity\Commande;
use Doctrine\ORM\Events;
use App\Entity\PortionFrites;
use App\Entity\TailleBoisson;
use App\Services\ImageService;
use App\Services\TypeService;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserSubscriber implements EventSubscriberInterface
{
    private ?TokenInterface $token;
    private $typeService;
    private $imageService;
    
    public function __construct
    (
        TokenStorageInterface $tokenStorage, 
        TypeService $typeService,
        ImageService $imageService
    )
    {
        $this->token = $tokenStorage->getToken();
        $this->typeService = $typeService;
        $this->imageService = $imageService;
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
            $this->typeService->typeSetter($args->getObject());
            $args->getObject()->setUser($this->getUser());
            $args->getObject()->setImage(file_get_contents($args->getObject()->getPlaineImage()));
        }elseif($args->getObject() instanceof Commande){
            // $args->getObject()->setClient($this->getUser());
        }
        if (($args->getObject() instanceof Boisson)) {
            $this->imageService->insertImage($args->getObject());
        }
        
    }
    
}
