<?php

namespace AppBundle\Exception;

use \RuntimeException;

class LeagueCreateException extends RuntimeException
{
    const MESSAGE = 'League with this name already exists.';

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
