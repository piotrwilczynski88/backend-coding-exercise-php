<?php

namespace App\Rules;

use App\Models\Menu;

interface IMenuRule
{
    public function validate(Menu $menu): bool;
}
