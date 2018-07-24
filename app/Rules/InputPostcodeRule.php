<?php

namespace App\Rules;

class InputPostcodeRule implements IInputValidationRule
{
    public function validate($postcode): bool
    {
        return mb_strlen($postcode) > 5 && mb_strlen($postcode) < 9;
    }
}
