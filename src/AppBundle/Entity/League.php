<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Team;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LeagueRepository")
 * @ORM\Table(name="leagues")
 */
class League
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $name;

    /**
     * One League has Many Teams
     *
     * @ORM\OneToMany(targetEntity="Team", mappedBy="league", cascade={"remove"})
     *
     * @var Team[]
     */
    private $teams;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return Team[]
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * @param Team[] $teams
     */
    public function setTeams($teams)
    {
        $this->teams = $teams;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $teams = $this->getTeams();
        $teamsArray = [];

        if ($teams && count($teams)) {
            foreach ($teams as $team) {
                $teamsArray[] = $team->toArray();
            }
        }

        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "teams" => $teamsArray,
        ];
    }
}
