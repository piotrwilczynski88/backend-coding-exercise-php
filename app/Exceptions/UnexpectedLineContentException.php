<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class UnexpectedLineContentException extends Exception
{
    const EXCEPTION_MESSAGE = 'Unexpected line content';

    public function __construct(string $message = self::EXCEPTION_MESSAGE, int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
