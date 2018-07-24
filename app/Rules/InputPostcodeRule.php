<?php

namespace App\Rules;

class InputPostcodeRule implements IInputValidationRule
{
    public function validate($postcode): bool
    {
        // TODO: this needs additional validation
        return mb_strlen($postcode) > 5 && mb_strlen($postcode) < 9;
    }
}
