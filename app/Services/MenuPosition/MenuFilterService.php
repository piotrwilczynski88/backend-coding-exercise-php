<?php

namespace App\Services\MenuPosition;

use App\Models\Meal;
use App\Models\Menu;
use App\Rules\IMealRule;
use App\Rules\IMenuRule;

class MenuFilterService
{
    /**
     * @param Menu[]           $menus
     * @param IMenuRule[]      $menuRules
     * @param IMealRule[]|null $mealRules
     *
     * @return array
     */
    public function filter(array $menus, array $menuRules, $mealRules = []): array
    {
        return array_filter($menus, function ($menu) use ($menuRules, $mealRules) {
            /* @var Menu $menu */
            foreach ($menuRules as $rule) {
                if (!$rule->validate($menu)) {
                    return false;
                }
            }
            $menu->setMeals($this->filterMeals($menu->getMeals(), $mealRules));
            if (empty($menu->getMeals())) {
                return false;
            }

            return true;
        });
    }

    /**
     * @param Meal[]      $meals
     * @param IMealRule[] $mealRules
     *
     * @return Meal[]
     */
    protected function filterMeals(array $meals, array $mealRules): array
    {
        return array_filter($meals, function ($meal) use ($mealRules) {
            foreach ($mealRules as $rule) {
                if (!$rule->validate($meal)) {
                    return false;
                }
            }

            return true;
        });
    }
}
