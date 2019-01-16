<?php

namespace AppBundle\Listener;

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
}
