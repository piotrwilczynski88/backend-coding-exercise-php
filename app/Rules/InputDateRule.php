<?php

namespace App\Rules;

use DateTime;

class InputDateRule implements IInputValidationRule
{
    public function validate($dateString): bool
    {
        return false !== DateTime::createFromFormat('d/m/y', $dateString);
    }
}
