<?php

namespace AppBundle\Exception;

use \RuntimeException;

class TeamCreateException extends RuntimeException
{
    const MESSAGE = 'Team already exists.';

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
