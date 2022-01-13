<?php

namespace App\EventListener;

use App\Entity\PlayedCharacter;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;

class CharacterChangeListener {
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function prePersist(PlayedCharacter $playedCharacter, LifecycleEventArgs $args)
    {
        $playedCharacter->setAccount($this->security->getUser());
    }

}