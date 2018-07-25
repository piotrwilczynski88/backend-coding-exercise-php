<?php

namespace Tests;

use App\Models\AdvanceTime;
use App\Models\Meal;
use App\Models\Menu;
use App\Models\Vendor;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function createVendor(string $vendorName, string $vendorPostcode, int $vendorMaxCovers): Vendor
    {
        return new Vendor($vendorName, $vendorPostcode, $vendorMaxCovers);
    }

    protected function createMeal($name, AdvanceTime $advanceTime): Meal
    {
        return new Meal($name, $advanceTime, []);
    }

    protected function createMenu(Vendor $vendor, array $meals = []): Menu
    {
        $menu = new Menu($vendor);
        $menu->setMeals($meals);
        return $menu;
    }
}
