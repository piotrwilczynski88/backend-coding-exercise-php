<?php

namespace App\Rules;

class InputDateRule implements IInputValidationRule
{
    public function validate($dateString): bool
    {
        if (!preg_match('/^\d{2}\/\d{2}\/\d{2}$/', $dateString)) {
            return false;
        }
        $date = explode('/', $dateString);
        [$day, $month, $year] = $date;

        return preg_match('/^\d{2}\/\d{2}\/\d{2}$/', $dateString) && checkdate($month, $day, $year);
    }
}
