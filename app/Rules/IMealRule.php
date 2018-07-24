<?php

namespace App\Rules;

use App\Models\Meal;

interface IMealRule
{
    public function validate(Meal $meal): bool;
}
