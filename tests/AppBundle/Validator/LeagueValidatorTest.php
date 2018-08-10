<?php

namespace AppBundle\Validator;

use PHPUnit\Framework\TestCase;
use AppBundle\Validation\LeagueValidator;
use Symfony\Component\HttpFoundation\Request;
use Mockery;
use Exception;

class LeagueValidatorTest extends TestCase
{
    /**
     * Check for valid input
     */
    public function testIsValid()
    {
        $data = ["name" => "My League Name"];
        $json = json_encode($data);
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('getContent')->once()->andReturn($json);
        $validator = new LeagueValidator();
        $this->assertEquals($validator->isValid($request), $data);
    }

    /**
     * Check for invalid input
     */
    public function testNotValid()
    {
        $this->expectException(Exception::class);
        $data = ["wrong-param" => "My League Name"];
        $json = json_encode($data);
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('getContent')->once()->andReturn($json);
        $validator = new LeagueValidator();
        $this->assertEquals($validator->isValid($request), $data);
    }
}
