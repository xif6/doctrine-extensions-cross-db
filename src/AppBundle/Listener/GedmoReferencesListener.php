<?php

namespace AppBundle\Listener;

use AppBundle\Interfaces\ProxifyEntity;
use AppBundle\Traits\ProxyEntity;
use Bdd1Bundle\Entity\LinkedAccount as LinkedAccount1;
use Bdd2Bundle\Entity\LinkedAccount as LinkedAccount2;
use Bdd1Bundle\Entity\User as User1;
use Bdd2Bundle\Entity\User as User2;
use Bdd2Bundle\Entity\UserTag;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\EventArgs;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\Common\Persistence\ObjectManager;
use Gedmo\Mapping\ExtensionMetadataFactory;
use Gedmo\References\ReferencesListener;

/**
 * Created by PhpStorm.
 * User: xif6
 * Date: 11/01/2019
 * Time: 14:29
 */

class GedmoReferencesListener extends ReferencesListener
{
    protected function getNamespace()
    {
        return __NAMESPACE__;
    }

    public function getSubscribedEvents()
    {
        $events = parent::getSubscribedEvents();
        $events[] = 'postUpdate';
        $events[] = 'postPersist';
        return $events;
    }

    public function postUpdate(EventArgs $eventArgs)
    {
        $entity = $eventArgs->getObject();

        if ($entity instanceof UserTag) {
            if ($entity->getUserId() === null || $entity->getTag() === null) {
                $ea = $this->getEventAdapter($eventArgs);
                $om = $ea->getObjectManager();
                $om->remove($entity);
            }
        }
    }


    public function postPersist(EventArgs $eventArgs)
    {
        $ea = $this->getEventAdapter($eventArgs);
        $entity = $ea->getObject();

        if ($entity instanceof ProxifyEntity) {
            $class2 = str_replace('Bdd1Bundle', 'Bdd2Bundle', get_class($entity));
            $em2 = $this->getManager('default2');
            $entity2 = $class2::setId($entity->getId());
            if ($entity instanceof LinkedAccount1) {
                $user2 = $em2->getRepository(User2::class, 'default2')->find($entity->getOwner()->getId());
                $entity2->setOwner($user2);
            }
            $em2->persist($entity2);
            $em2->flush();
        }
    }
}
