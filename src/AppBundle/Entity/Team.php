<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\League;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TeamRepository")
 * @ORM\Table(name="teams")
 */
class Team
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
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $strip;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $league_id;

    /**
     * Many Teams have One League
     *
     * @ORM\ManyToOne(targetEntity="League", inversedBy="teams")
     * @ORM\JoinColumn(name="league_id", referencedColumnName="id")
     */
    private $league;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getStrip()
    {
        return $this->strip;
    }

    /**
     * @param integer $strip
     */
    public function setStrip($strip)
    {
        $this->strip = $strip;
    }

    /**
     * @return mixed
     */
    public function getLeague()
    {
        return $this->league;
    }

    /**
     * @param $league
     */
    public function setLeague($league)
    {
        $this->league = $league;
    }

    /**
     * @return integer
     */
    public function getLeagueId()
    {
        return $this->league_id;
    }

    /**
     * @param $leagueId
     */
    public function setLeagueId($leagueId)
    {
        $this->league_id = $leagueId;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "strip" => $this->getStrip(),
            "league_id" => $this->getLeagueId(),
        ];
    }
}
