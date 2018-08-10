<?php

namespace AppBundle\Entity;

use PHPUnit\Framework\TestCase;
use AppBundle\Entity\League;
use AppBundle\Entity\Team;

class LeagueTest extends TestCase
{
    public function testToArray()
    {
        $team = new Team();
        $team->setLeagueId(1);
        $team->setId(1);
        $team->setName("Man Utd");
        $team->setStrip("Red&White");


        $league = new League();
        $league->setName("Premier League");
        $league->setId(1);
        $league->setTeams([$team]);

        $expected = [
            "id" => "1",
            "name" => "Premier League",
            "teams" => [
                [
                    "id" => "1",
                    "name" => "Man Utd",
                    "strip" => "Red&White",
                    "league_id" => "1",
                ]
            ]
        ];

        $this->assertEquals($league->toArray(), $expected);
    }
}
