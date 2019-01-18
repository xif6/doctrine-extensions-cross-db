<?php

namespace Bdd1Bundle\Entity;

use AppBundle\Interfaces\ProxifyEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * LinkedAccount
 *
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap
 * (
 *      {
 *          "physical" = "PhysicalAccount",
 *          "holding" = "HoldingAccount"
 *      }
 * )
 *
 * @ORM\Table(name="linked_account")
 * @ORM\Entity(repositoryClass="Bdd1Bundle\Repository\LinkedAccountRepository")
 */
abstract class LinkedAccount implements ProxifyEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="linkedAccounts")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $owner;

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
     * Set name
     *
     * @param string $name
     *
     * @return LinkedAccount
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get owner
     *
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set owner
     *
     * @param User $owner
     *
     * @return LinkedAccount
     */
    public function setOwner(User $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

}

