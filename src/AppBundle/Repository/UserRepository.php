<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\User;

class UserRepository extends EntityRepository
{
    public function save(User $user) : User
    {
        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();

        return $user;
    }
}
