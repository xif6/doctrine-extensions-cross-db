<?php

namespace Bdd1Bundle\Entity;

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
 * @ORM\Entity(repositoryClass="Bdd1Bundle\Repository\UserRepository")
 */
class User
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
     * @var int
     *
     * @ORM\Column(name="category_id", type="integer", nullable=true)
     */
    private $categoryId;

    /**
     * @var Category
     *
     * @Gedmo\ReferenceOne(type="default2", class="Bdd2Bundle\Entity\Category", identifier="categoryId")
     */
    private $category;

    /**
     * @var Collection|Tag[]
     *
     * @Gedmo\ReferenceMany(type="default2", class="Bdd2Bundle\Entity\UserTag", mappedBy="user")
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
     * @return User
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
     * Set categoryId
     *
     * @param integer $categoryId
     *
     * @return User
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Get category
     *
     * @return Category
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * Set category
     *
     * @param Category $category
     * @return User
     */
    public function setCategory(?Category $category): self
    {
        $this->category = $category;
        if ($category) {
            $this->setCategoryId($category->getId());
        } else {
            $this->setCategoryId(null);
        }

        return $this;
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
        $userTag->setUser(null);

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
     * Get tags.
     *
     * @return Collection|null
     */
    public function getTags()
    {
        $tags = new ArrayCollection();
        foreach ($this->userTag as $userTag) {
            if ($userTag->getTag()) {
                $tags[] = $userTag->getTag();
            }
        }

        return $tags;
    }

    /**
     * Set tags.
     *
     * @param ArrayCollection $tags
     *
     * @return User
     */
    public function setTags(ArrayCollection $tags): self
    {
        foreach ($this->userTag as $userTag) {
            $this->removeUserTag($userTag);
            if ($userTag->getTag()) {
                $userTag->getTag()->removeUserTag($userTag);
            }
        }
        foreach ($tags as $tag) {
            $this->addTag($tag);
        }

        return $this;
    }

    /**
     * Add tag.
     *
     * @param Tag $tag
     *
     * @return User
     */
    public function addTag(Tag $tag): self
    {
        foreach ($this->userTag as $userTag) {
            if ($userTag->getTag() && $tag->getId() === $userTag->getTag()->getId()) {
                return $this;
            }
        }
        $userTag = new UserTag();
        $userTag->setTag($tag);
        $userTag->setUser($this);
        $this->addUserTag($userTag);
        $tag->addUserTag($userTag);

        return $this;
    }

    /**
     * Remove tag.
     *
     * @param Tag $tag
     *
     * @return User
     */
    public function removeTag(Tag $tag): self
    {
        foreach ($this->userTag as $userTag) {
            if ($userTag->getTag() && $tag->getId() === $userTag->getTag()->getId()) {
                $this->removeUserTag($userTag);
                $tag->removeUserTag($userTag);
                break;
            }
        }

        return $this;
    }
}

