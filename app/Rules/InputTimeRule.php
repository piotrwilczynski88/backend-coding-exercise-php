<?php

namespace App\Rules;

class InputTimeRule implements IInputValidationRule
{
    public function validate($timeStringRule): bool
    {
        if (preg_match('/^[0-1]{1}[0-9]{1}:[0-5]{1}[0-9]{1}$/', $timeStringRule)) {
            return true;
        }
        if (preg_match('/^[2]{1}[0-3]{1}:[0-5]{1}[0-9]{1}$/', $timeStringRule)) {
            return true;
        }

        return false;
    }
}
