<?php

namespace App\Rules;

class InputTimeRule implements IInputValidationRule
{
    public function validate($timeStringRule): bool
    {
        return preg_match('%^([0-1][0-9])|([2][0-3]):[0-5][0-9]$%', $timeStringRule);
    }
}
