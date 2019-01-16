<?php

namespace Bdd2Bundle\Entity;

use Bdd1Bundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * UserTag
 *
 * @ORM\Table(name="user_tag")
 * @ORM\Entity(repositoryClass="Bdd2Bundle\Repository\UserTagRepository")
 */
class UserTag
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
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @var User
     *
     * @Gedmo\ReferenceOne(type="default1", class="Bdd1Bundle\Entity\User", identifier="userId")
     */
    private $user;


    /**
     * @var Tag
     *
     * @ORM\ManyToOne(targetEntity="Bdd2Bundle\Entity\Tag", inversedBy="userTag", cascade={"all"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $tag;

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
     * Get tag
     *
     * @return Tag
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set tag
     *
     * @param Tag $tag
     * @return UserTag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
        return $this;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return UserTag
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Add user.
     *
     * @param User $user
     *
     * @return self
     */
    public function addUser(User $user): self
    {
        $user->addTag($this);
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user.
     *
     * @param User $user
     *
     * @return self
     */
    public function removeUser(User $user): self
    {
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

    /**
     * Set tags.
     *
     * @param ArrayCollection $users
     *
     * @return User
     */
    public function setUsers(ArrayCollection $users): self
    {
        $this->users = $users;

        return $this;
    }


    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @param User $user
     * @return UserTag
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }
}

