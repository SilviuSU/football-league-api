<?php

namespace AppBundle\Entity;

use PHPUnit\Framework\TestCase;
use AppBundle\Services\LeagueService;
use AppBundle\Repository\LeagueRepository;
use Mockery;

class LeagueServiceTest extends TestCase
{
    public function testCreate()
    {
        $league = new League();
        $league->setName("Premier League");

        $repository = Mockery::mock(LeagueRepository::class);
        $repository->shouldReceive('save')->once()->andReturn($league);
        $repository->shouldReceive('findOneByName')->once()->andReturn(null);

        $leagueService = new LeagueService($repository);

        $this->assertEquals(
            $leagueService->create("Premier League"),
            $league
        );
    }

    public function testDelete()
    {
        $repository = Mockery::mock(LeagueRepository::class);
        $repository->shouldReceive('delete')->once()->andReturn(true);

        $leagueService = new LeagueService($repository);

        $this->assertEquals(
            $leagueService->delete(1),
            true
        );
    }

    public function testGet()
    {
        $league = new League();
        $league->setId(1);
        $league->setName("Premier League");

        $repository = Mockery::mock(LeagueRepository::class);
        $repository->shouldReceive('find')->once()->andReturn($league);

        $leagueService = new LeagueService($repository);

        $this->assertEquals(
            $leagueService->get(1),
            $league
        );
    }
}
