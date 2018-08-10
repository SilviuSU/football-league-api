<?php

namespace AppBundle\Entity;

use PHPUnit\Framework\TestCase;
use AppBundle\Services\UserService;
use AppBundle\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Mockery;

class UserServiceTest extends TestCase
{
    public function testCreate()
    {
        $encoder = Mockery::mock(UserPasswordEncoderInterface::class);
        $encoder->shouldReceive('encodePassword')->once()->andReturn("Pass123");

        $user = new User();
        $user->setId(1);
        $user->setEmail("test@example.com");
        $user->setPassword("Pass123");
        $user->setRoles(["ROLE_ADMIN"]);

        $repository = Mockery::mock(UserRepository::class);
        $repository->shouldReceive('save')->once()->andReturn($user);
        $repository->shouldReceive('findOneByEmail')->once()->andReturn(null);

        $userService = new UserService($repository);

        $this->assertEquals(
            $userService->create("test@example.com", "Pass123", "ROLE_ADMIN", $encoder),
            $user
        );
    }

    public function testGet()
    {
        $user = new User();
        $user->setId(1);
        $user->setEmail("test@example.com");
        $user->setPassword("Pass123");
        $user->setRoles(["ROLE_ADMIN"]);

        $repository = Mockery::mock(UserRepository::class);
        $repository->shouldReceive('findOneByEmail')->once()->andReturn($user);

        $userService = new UserService($repository);

        $this->assertEquals(
            $userService->get("test@example.com"),
            $user
        );
    }
}
