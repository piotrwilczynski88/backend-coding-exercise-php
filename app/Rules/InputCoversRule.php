<?php

namespace App\Rules;

class InputCoversRule implements IInputValidationRule
{
    public function validate($coversString): bool
    {
        if (is_string($coversString)) {
            return ctype_digit($coversString) && (int) $coversString > 0;
        }

        return is_int($coversString) && $coversString > 0;
    }
}
