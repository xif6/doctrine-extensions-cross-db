<?php

namespace Bdd2Bundle\Entity;

use Bdd1Bundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="Bdd2Bundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var Collection|User[]
     *
     * @Gedmo\ReferenceMany(type="default1", class="Bdd1Bundle\Entity\User", mappedBy="category")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Category
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
     * Add user.
     *
     * @param User $user
     *
     * @return Category
     */
    public function addUser(User $user): self
    {
        $user->setCategory($this);
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user.
     *
     * @param User $user
     *
     * @return Category
     */
    public function removeUser(User $user): self
    {
        if ($user->getCategory() === $this) {
            $user->setCategory(null);
        }
        $this->users->removeElement($user);

        return $this;
    }

    /**
     * Get users.
     *
     * @return Collection|User[]
     */
    public function getUsers()
    {
        return $this->users;
    }
}

