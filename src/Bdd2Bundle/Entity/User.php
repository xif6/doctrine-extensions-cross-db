<?php

namespace Bdd2Bundle\Entity;

use AppBundle\Traits\ProxyEntity;
use Bdd2Bundle\Entity\Category;
use Bdd2Bundle\Entity\Tag;
use Bdd2Bundle\Entity\UserTag;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Bdd2Bundle\Repository\UserRepository")
 */
class User
{
    use ProxyEntity;

    /**
     * @var Category
     *
     * @Gedmo\ReferenceOne(type="default1", class="Bdd1Bundle\Entity\User", identifier="id")
     */
    protected $proxy;

    /**
     * @var Collection|LinkedAccount[]
     *
     * @ORM\OneToMany(
     *     targetEntity="LinkedAccount",
     *     mappedBy="owner",
     *     cascade={"persist"}
     *     )
     */
    private $linkedAccounts;


    /**
     * Get linked accounts.
     *
     * @return Collection|LinkedAccount[]
     */
    public function getLinkedAccounts()
    {
        return $this->linkedAccounts;
    }

    /**
     * Set linked accounts.
     *
     * @param Collection|LinkedAccount[] $linkedAccounts
     *
     * @return User
     */
    public function setLinkedAccounts(Collection $linkedAccounts): self
    {
        $this->linkedAccounts = $linkedAccounts;

        return $this;
    }

    /**
     * Add a linked account.
     *
     * @param LinkedAccount $linkedAccount
     *
     * @return User
     */
    public function addLinkedAccount(LinkedAccount $linkedAccount): self
    {
        if (!$this->linkedAccounts->contains($linkedAccount)) {
            $this->linkedAccounts->add($linkedAccount);
        }

        return $this;
    }
}

