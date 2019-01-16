<?php

namespace Bdd2Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gamer
 *
 * @ORM\Table(name="gamer")
 * @ORM\Entity(repositoryClass="Bdd2Bundle\Repository\GamerRepository")
 */
class Gamer
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
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="gamers")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id")
     */
    private $game;

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
     * Get game
     *
     * @return mixed
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set game
     *
     * @param mixed $game
     * @return Gamer
     */
    public function setGame($game)
    {
        $this->game = $game;
        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Gamer
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

