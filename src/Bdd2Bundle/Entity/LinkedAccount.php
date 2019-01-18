<?php

namespace Bdd2Bundle\Entity;

use AppBundle\Traits\ProxyEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

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
 * @ORM\Entity(repositoryClass="Bdd2Bundle\Repository\LinkedAccountRepository")
 */
abstract class LinkedAccount
{
    use ProxyEntity;

    /**
     * @var Category
     *
     * @Gedmo\ReferenceOne(type="default1", class="Bdd1Bundle\Entity\LinkedAccount", identifier="id")
     */
    protected $proxy;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="linkedAccounts")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $owner;

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

