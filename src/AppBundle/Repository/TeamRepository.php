<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Team;

/**
 * Class TeamRepository
 * @package AppBundle\Repository
 */
class TeamRepository extends EntityRepository
{
    /**
     * @param Team $team
     *
     * @return Team
     */
    public function save(Team $team) : Team
    {
        $em = $this->getEntityManager();
        $em->persist($team);
        $em->flush();

        return $team;
    }

    /**
     * @param $id
     *
     * @return boolean
     */
    public function delete($id) : bool
    {
        $em = $this->getEntityManager();

        $team = $this->find($id);

        $em->remove($team);
        $em->flush();

        return true;
    }
}
