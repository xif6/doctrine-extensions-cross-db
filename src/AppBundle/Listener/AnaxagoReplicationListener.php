<?php
/**
 * Created by PhpStorm.
 * User: xif6
 * Date: 25/01/2019
 * Time: 13:31
 */

namespace AppBundle\Listener;


use Bdd1Bundle\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Events;
use Doctrine\ORM\Query\ResultSetMapping;

class AnaxagoReplicationListener implements EventSubscriber
{
    /**
     * @var EntityManager[]
     */
    protected $managers;

    public function __construct(array $managers = array())
    {
        $this->managers = $managers;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
            Events::postUpdate,
            Events::preRemove,
        ];
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        $entityManager = $args->getObjectManager();
        if ($entity instanceof User) {
            $sql = 'DELETE FROM user WHERE id = :id';

            $this->executeUser($sql, ['id' => $entity->getId()], $entityManager);
        }
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        $entityManager = $args->getObjectManager();
        if ($entity instanceof User) {
            $sql = 'INSERT INTO user (id, name) VALUES (:id, :name)';

            $this->executeUser($sql, $this->getParamsUser($entity), $entityManager);
        }
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        $entityManager = $args->getObjectManager();
        if ($entity instanceof User) {
            $sql = 'UPDATE user SET name = :name WHERE id = :id';

            $this->executeUser($sql, $this->getParamsUser($entity), $entityManager);
        }
    }

    protected function getParamsUser($user) {
        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
        ];
    }

    protected function executeUser($sql, $params, $emCurrent) {
        try {

            foreach ( $this->managers as $em) {
                if ($em === $emCurrent) {
                    continue;
                }
                $em->getConnection()->prepare('START TRANSACTION')->execute();

                $em->getConnection()->prepare($sql)->execute($params);
            }
        } catch (\Exception $e) {
            foreach ( $this->managers as $em) {
                if ($em === $emCurrent) {
                    continue;
                }
                $em->getConnection()->prepare('ROLLBACK')->execute();
            }
            throw $e;
        }

        foreach ( $this->managers as $em) {
            if ($em === $emCurrent) {
                continue;
            }
            $em->getConnection()->prepare('COMMIT')->execute();
        }
    }
}
