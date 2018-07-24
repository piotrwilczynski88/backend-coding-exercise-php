<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ValidationException extends Exception
{
    const EXCEPTION_MESSAGE = 'Invalid data for: ';

    public function __construct(string $attributeName = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct(static::EXCEPTION_MESSAGE . $attributeName, $code, $previous);
    }
}
