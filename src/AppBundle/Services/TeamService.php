<?php

namespace AppBundle\Services;

use AppBundle\Repository\TeamRepository;
use AppBundle\Entity\Team;
use Symfony\Component\Config\Definition\Exception\Exception;
use AppBundle\Exception\TeamCreateException;

class TeamService
{
    /** @var  TeamRepository */
    private $repository;

    /** @var  LeagueService */
    private $leagueService;

    /**
     * @param TeamRepository $repository
     *
     * @param \AppBundle\Services\LeagueService $leagueService
     */
    public function __construct(TeamRepository $repository, LeagueService $leagueService)
    {
        $this->repository = $repository;
        $this->leagueService = $leagueService;
    }

    /**
     * @param $name
     * @param $stripe
     * @param $leagueId
     *
     * @return Team
     *
     * @throws TeamCreateException
     */
    public function create(string $name, string $stripe, $leagueId) : Team
    {
        $team = new Team();
        $team->setName($name);
        $team->setStrip($stripe);

        if ($this->getByName($name)) {
            throw new TeamCreateException("Team already exists.");
        }

        if ($this->getByStripe($stripe)) {
            throw new TeamCreateException("Stripe must be unique.");
        }

        $league = $this->leagueService->get($leagueId);

        if ($league) {
            $team->setLeague($league);
            $team->setLeagueId($leagueId);
        } else {
            throw new TeamCreateException("League not found.");
        }

        return $this->repository->save($team);
    }

    /**
     * @param $id
     * @param $name
     * @param $stripe
     * @param $leagueId
     *
     * @return Team
     */
    public function update($id, string $name, string $stripe, $leagueId) : Team
    {
        $team = $this->get($id);

        if (!$team) {
            throw new Exception("Team not found.");
        }

        $team->setName($name);
        $team->setStrip($stripe);

        if ($this->getByName($name)) {
            throw new TeamCreateException("Team already exists.");
        }

        if ($this->getByStripe($stripe)) {
            throw new TeamCreateException("Stripe must be unique.");
        }

        $league = $this->leagueService->get($leagueId);

        if (!$league) {
            throw new TeamCreateException("League not found.");
        }

        $team->setLeague($league);
        $team->setLeagueId($leagueId);

        return $this->repository->save($team);
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    /**
     * @param int $id
     *
     * @return Team|null
     */
    public function get($id)
    {

        return $this->repository->find($id);
    }

    /**
     * @param $name
     *
     * @return Team|null
     */
    public function getByName(string $name)
    {
        return $this->repository->findOneByName($name);
    }

    /**
     * @param $stripe
     *
     * @return Team|null
     */
    public function getByStripe(string $stripe)
    {
        return $this->repository->findOneByStrip($stripe);
    }
}
