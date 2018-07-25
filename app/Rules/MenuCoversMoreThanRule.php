<?php

namespace App\Rules;

use App\Models\Menu;

class MenuCoversMoreThanRule implements IMenuRule
{
    protected $minCovers;

    public function __construct($minCovers)
    {
        $this->minCovers = $minCovers;
    }

    public function validate(Menu $menu): bool
    {
        return $menu->getVendor()->getMaxCovers() >= $this->minCovers;
    }
}
