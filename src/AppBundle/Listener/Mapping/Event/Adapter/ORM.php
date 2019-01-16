<?php
/**
 * Created by PhpStorm.
 * User: xif6
 * Date: 11/01/2019
 * Time: 15:11
 */

namespace AppBundle\Listener\Mapping\Event\Adapter;

use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Mapping\Event\Adapter\ORM as BaseAdapterORM;
use Gedmo\References\Mapping\Event\ReferencesAdapter;
use Doctrine\ORM\Proxy\Proxy as ORMProxy;

class ORM extends BaseAdapterORM implements ReferencesAdapter
{
    /**
     * @inheritDoc
     *
     * @var EntityManagerInterface $om
     */
    public function getIdentifier($om, $object, $single = true)
    {
        if ($om instanceof EntityManagerInterface) {
            return $this->extractIdentifier($om, $object, $single);
        }
    }

    /**
     * @inheritDoc
     *
     * @var EntityManagerInterface $om
     */
    public function getSingleReference($om, $class, $identifier)
    {
        $this->throwIfNotEntityManager($om);
        $meta = $om->getClassMetadata($class);

        if (!$meta->isInheritanceTypeNone()) {
            return $om->find($class, $identifier);
        }

        return $om->getReference($class, $identifier);
    }

    /**
     * @inheritDoc
     *
     * @var EntityManagerInterface $om
     */
    public function extractIdentifier($om, $object, $single = true)
    {
        if ($object instanceof ORMProxy) {
            $id = $om->getUnitOfWork()->getEntityIdentifier($object);
        } else {
            $meta = $om->getClassMetadata(get_class($object));
            $id = array();
            foreach ($meta->identifier as $name) {
                $id[$name] = $meta->getReflectionProperty($name)->getValue($object);
                // return null if one of identifiers is missing
                if (!$id[$name]) {
                    return null;
                }
            }
        }

        if ($single) {
            $id = current($id);
        }

        return $id;
    }

    /**
     * Override so we don't get an exception. We want to allow this.
     */
    private function throwIfNotEntityManager(EntityManagerInterface $em)
    {
    }
}
