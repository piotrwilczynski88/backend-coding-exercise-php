<?php

namespace App\Rules;

use App\Models\Menu;

class MenuPostcodeRule implements IMenuRule
{
    /** @var string */
    protected $postcode;

    public function __construct($postcode)
    {
        $this->postcode = $postcode;
    }

    public function validate(Menu $menu): bool
    {
        return mb_substr($menu->getVendor()->getPostcode(), 0, 2) === mb_substr($this->postcode, 0, 2);
    }
}
