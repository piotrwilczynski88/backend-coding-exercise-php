<?php

namespace App\Validators;

use App\Exceptions\ValidationException;
use Symfony\Component\Console\Input\InputInterface;

interface IInputValidator
{
    /**
     * @throws ValidationException
     */
    public function validate(InputInterface $input);
}
