<?php

namespace App\Rules;

class InputCoversRule implements IInputValidationRule
{
    public function validate($coversString): bool
    {
        return (int) $coversString > 0;
    }
}
