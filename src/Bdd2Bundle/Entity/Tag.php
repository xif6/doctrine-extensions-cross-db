<?php

namespace Bdd2Bundle\Entity;

use Bdd1Bundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tag
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="Bdd2Bundle\Repository\TagRepository")
 */
class Tag
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
     * @ORM\OneToMany(targetEntity="Bdd2Bundle\Entity\UserTag", mappedBy="tag", fetch="EAGER", cascade={"all"})
     */
    private $userTag;

    public function __construct()
    {
        $this->userTag = new ArrayCollection();
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
     * @return Tag
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
     * Add userTag.
     *
     * @param UserTag $userTag
     *
     * @return Category
     */
    public function addUserTag(UserTag $userTag): self
    {
        if ($this->userTag->contains($userTag)) {
            return $this;
        }

        $this->userTag[] = $userTag;

        return $this;
    }

    /**
     * Remove userTag.
     *
     * @param UserTag $userTag
     *
     * @return Category
     */
    public function removeUserTag(UserTag $userTag): self
    {
        $this->userTag->removeElement($userTag);
        $userTag->setTag(null);

        return $this;
    }

    /**
     * Get userTags.
     *
     * @return Collection|UserTag[]
     */
    public function getUserTags()
    {
        return $this->userTag;
    }

    /**
     * Get users.
     *
     * @return Collection|User[]
     */
    public function getUsers()
    {
        $users = new ArrayCollection();
        foreach ($this->userTag as $userTag) {
            $users[] = $userTag->getUser();
        }

        return $users;
    }

    /**
     * Set tags.
     *
     * @param ArrayCollection $users
     *
     * @return self
     */
    public function setUsers(ArrayCollection $users): self
    {
        foreach ($this->userTag as $userTag) {
            $this->removeUserTag($userTag);
            if ($userTag->getUser()) {
                $userTag->getUser()->removeUserTag($userTag);
            }
        }
        foreach ($users as $user) {
            $this->addUser($user);
        }

        return $this;
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
        foreach ($this->userTag as $userTag) {
            if ($userTag->getUser() && $user->getId() === $userTag->getUser()->getId()) {
                return $this;
            }
        }
        $userTag = new UserTag();
        $userTag->setTag($this);
        $userTag->setUser($user);
        $this->addUserTag($userTag);
        $user->addUserTag($userTag);

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
        foreach ($this->userTag as $userTag) {
            if ($userTag->getUser() && $user->getId() === $userTag->getUser()->getId()) {
                $this->removeUserTag($userTag);
                $user->removeUserTag($userTag);
                break;
            }
        }

        return $this;
    }


}

