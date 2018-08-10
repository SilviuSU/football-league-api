<?php

namespace AppBundle\Services;

use AppBundle\Repository\UserRepository;
use AppBundle\Entity\User;
use AppBundle\Exception\UserCreateException;

class UserService
{
    /** @var  UserRepository */
    private $repository;

    /**
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $email
     * @param $password
     * @param $role
     * @param $passwordEncoder
     *
     * @return User
     *
     * @throws UserCreateException
     */
    public function create(string $email, string $password, string $role, $passwordEncoder) : User
    {
        $user = $this->get($email);

        if ($user) {
            throw new UserCreateException("This email already exists.");
        }

        $user = new User();
        $password = $passwordEncoder->encodePassword($user, $password);
        $user->setPassword($password);
        $user->setEmail($email);
        $user->setRoles(["$role"]);

        return $this->repository->save($user);
    }

    /**
     * @param $email
     *
     * @return User|null
     */
    public function get(string $email)
    {
        return $this->repository->findOneByEmail($email);
    }
}
