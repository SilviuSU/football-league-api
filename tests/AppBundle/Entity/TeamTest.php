<?php

namespace AppBundle\Entity;

use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Team;

class TeamTest extends TestCase
{
    public function testToArray()
    {
        $team = new Team();
        $team->setLeagueId(1);
        $team->setId(1);
        $team->setName("F.C. Steaua Bucharest");
        $team->setStrip("red&blue");

        $expected = [
            "id" => 1,
            "name" => "F.C. Steaua Bucharest",
            "strip" => "red&blue",
            "league_id" => 1,
        ];

        $this->assertEquals($team->toArray(), $expected);
    }
}
