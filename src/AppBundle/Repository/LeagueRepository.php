<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\League;

/**
 * Class LeagueRepository
 * @package AppBundle\Repository
 */
class LeagueRepository extends EntityRepository
{
    /**
     * @param League $league
     *
     * @return League
     */
    public function save(League $league) : League
    {
        $em = $this->getEntityManager();
        $em->persist($league);
        $em->flush();

        return $league;
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function delete($id) : bool
    {
        $em = $this->getEntityManager();

        $league = $this->find($id);

        $em->remove($league);
        $em->flush();

        return true;
    }
}
