<?php

namespace App\Rules;

interface IInputValidationRule
{
    public function validate($valueToCheck): bool;
}
