<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class CreateObjectException extends Exception
{
    const EXCEPTION_MESSAGE = 'Cannot create object ';

    public function __construct(string $modelName = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct(static::EXCEPTION_MESSAGE . $modelName, $code, $previous);
    }
}
