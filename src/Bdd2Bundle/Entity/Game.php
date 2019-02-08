<?php

namespace Bdd2Bundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="Bdd2Bundle\Repository\GameRepository")
 */
class Game
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Gamer", mappedBy="game", cascade={"persist", "remove"})
     */
    private $gamers;

    public function __construct()
    {
        $this->gamers = new ArrayCollection();
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
     * Get gamers
     *
     * @return mixed
     */
    public function getGamers()
    {
        return $this->gamers;
    }

    /**
     * Do addGamer
     *
     * @param Gamer $gamer
     *
     * @return $this
     */
    public function addGamer(Gamer $gamer)
    {
        $this->gamers->add($gamer);

        return $this;
    }

    public function removeGamer(Gamer $gamer)
    {
        $this->gamers->removeElement($gamer);
        $gamer->setGame(null);
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Game
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
}

