<?php

namespace AppBundle\Entity;

use PHPUnit\Framework\TestCase;
use AppBundle\Entity\User;

class UserTest extends TestCase
{
    public function testToArray()
    {
        $user = new User();
        $user->setId(1);
        $user->setEmail("test@example.com");
        $user->setPassword("Pass123");
        $user->setRoles(["ROLE_ADMIN"]);

        $expected = [
            "email" => "test@example.com",
            "password" => "Pass123",
            "roles" => ["ROLE_ADMIN"],
            "id" => 1,
        ];

        $this->assertEquals($user->toArray(), $expected);
    }
}
