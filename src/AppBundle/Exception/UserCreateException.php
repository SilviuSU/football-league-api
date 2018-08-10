<?php

namespace AppBundle\Exception;

use \RuntimeException;

class UserCreateException extends RuntimeException
{
    const MESSAGE = "This email already exists.";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
