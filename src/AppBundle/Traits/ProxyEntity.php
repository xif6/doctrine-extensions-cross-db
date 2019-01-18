<?php
/**
 * Created by PhpStorm.
 * User: xif6
 * Date: 18/01/2019
 * Time: 19:01
 */

namespace AppBundle\Traits;


trait ProxyEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    protected $id;

    /**
     * @var object
     */
    protected $proxy;

    private function __construct()
    {
    }


    public function __call($name, $arguments)
    {
        return $this->proxy->$name();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param int $id
     * @return self
     */
    public static function setId($id)
    {
        $class = __CLASS__;
        $entity = new static();
        $entity->id = $id;
        return $entity;
    }
}
