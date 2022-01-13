<?php

namespace App\EventListener;

use App\Entity\Account;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * A lifecycle callback into "Account" would surely have better performance
 * But by doing it this way I avoid injecting the service into the class constructor each time I need it
 * It's more "invisible" for the other parts of the code, who don't have to care about it
 */
class PasswordChangeListener implements EventSubscriber {
    private $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $pe)
    {
        $this->passwordEncoder = $pe;
    }

    public function getSubscribedEvents()
    {
        return ['prePersist', 'preUpdate'];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->encodePassword($args);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->encodePassword($args, true);
    }

    private function encodePassword(LifecycleEventArgs $args, $isAlreadyManaged = false)
    {
        $entity = $args->getEntity();
        if(!$entity instanceof Account) {
            return;
        }

        $encoded = $this->passwordEncoder->hashPassword(
            $entity,
            $entity->getPassword()
        );
        $entity->setPassword($encoded);

        if($isAlreadyManaged) {
            $em = $args->getEntityManager();
            $meta = $em->getClassMetadata(get_class($entity));
            $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);
        }
    }
}