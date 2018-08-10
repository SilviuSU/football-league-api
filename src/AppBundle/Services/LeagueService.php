<?php

namespace AppBundle\Services;

use AppBundle\Repository\LeagueRepository;
use AppBundle\Entity\League;
use AppBundle\Exception\LeagueCreateException;

class LeagueService
{
    /** @var  LeagueRepository */
    private $repository;

    /**
     * @param LeagueRepository $repository
     */
    public function __construct(LeagueRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $name
     *
     * @return League
     *
     * @throws LeagueCreateException
     */
    public function create(string $name) : League
    {
        if ($this->getByName($name)) {
            throw new LeagueCreateException();
        }

        $league = new League();
        $league->setName($name);

        return $this->repository->save($league);
    }

    /**
     * @param integer $id
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
     * @return League|null
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param $name
     *
     * @return League|null
     */
    public function getByName(string $name)
    {
        return $this->repository->findOneByName($name);
    }
}
