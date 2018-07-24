<?php

namespace App\Models;

class Menu
{
    /** @var Vendor|null */
    protected $vendor;

    /** @var array */
    protected $meals = [];

    /**
     * @return Vendor|null
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * @param Vendor $vendor
     */
    public function setVendor(Vendor $vendor): void
    {
        $this->vendor = $vendor;
    }

    public function addMeal(Meal $meal): void
    {
        $this->meals[] = $meal;
    }

    /**
     * @return Meal[]
     */
    public function getMeals(): array
    {
        return $this->meals;
    }

    public function setMeals(array $meals)
    {
        $this->meals = $meals;
    }
}
