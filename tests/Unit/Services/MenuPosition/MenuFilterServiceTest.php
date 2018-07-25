<?php

namespace Tests\Unit\Services;

use App\Models\AdvanceTime;
use App\Models\Menu;
use App\Rules\MealDeliveryDeadlineRule;
use App\Rules\MenuCoversMoreThanRule;
use App\Rules\MenuPostcodeRule;
use App\Services\MenuPosition\MenuFilterService;
use DateInterval;
use DateTime;
use Tests\TestCase;

class MenuFilterServiceTest extends TestCase
{
    public function testFilteredMeals(): void
    {
        $service = new MenuFilterService();

        $vendor = $this->createVendor('Vendor 1', '123456', 14);
        $meals = [];
        $menus = [];
        $meals[] = $this->createMeal('Meal 1', AdvanceTime::fromHours(4));
        $meals[] = $this->createMeal('Meal 2', AdvanceTime::fromHours(8));
        $meals[] = $this->createMeal('Meal 3', AdvanceTime::fromHours(16));
        $menus[] = $this->createMenu($vendor, $meals);

        $deadline = new DateTime();
        $deadline->add(new DateInterval('PT9H'));

        $filteredMenus = $service->filter($menus, $this->getMenuRules(12, '123987'), $this->getMealRules($deadline));

        $this->checkExpectations($filteredMenus, 1, 2);
    }

    public function testFilteredVendors(): void
    {
        $service = new MenuFilterService();

        $vendor1 = $this->createVendor('Vendor 1', '123456', 10);
        $menus = [];

        $meals = [];
        $meals[] = $this->createMeal('Meal 1', AdvanceTime::fromHours(4));
        $meals[] = $this->createMeal('Meal 2', AdvanceTime::fromHours(8));
        $meals[] = $this->createMeal('Meal 3', AdvanceTime::fromHours(16));
        $menus[] = $this->createMenu($vendor1, $meals);

        $vendor2 = $this->createVendor('Vendor 2', '223456', 14);
        $meals = [];
        $meals[] = $this->createMeal('Meal 4', AdvanceTime::fromHours(4));
        $meals[] = $this->createMeal('Meal 5', AdvanceTime::fromHours(9));
        $meals[] = $this->createMeal('Meal 6', AdvanceTime::fromHours(16));
        $menus[] = $this->createMenu($vendor2, $meals);

        $deadline = new DateTime();
        $deadline->add(new DateInterval('PT8H'));

        $filteredMenus = $service->filter($menus, $this->getMenuRules(10, '123987'), $this->getMealRules($deadline));

        $this->checkExpectations($filteredMenus, 1, 2);
    }

    public function testEmptyMenu(): void
    {
        $service = new MenuFilterService();

        $vendor = $this->createVendor('Vendor 1', '123456', 10);
        $menus = [];

        $meals = [];
        $meals[] = $this->createMeal('Meal 1', AdvanceTime::fromHours(14));
        $meals[] = $this->createMeal('Meal 2', AdvanceTime::fromHours(18));
        $meals[] = $this->createMeal('Meal 3', AdvanceTime::fromHours(16));
        $menus[] = $this->createMenu($vendor, $meals);

        $deadline = new DateTime();
        $deadline->add(new DateInterval('PT8H'));

        $filteredMenus = $service->filter($menus, $this->getMenuRules(5, '123987'), $this->getMealRules($deadline));

        $this->checkExpectations($filteredMenus, 0, 0);

    }

    private function checkExpectations(array $filteredMenus, int $expectedMenusCount, int $expectedMealsCount): void
    {
        $filteredMenusCount = 0;
        $filteredMealsCount = 0;
        /** @var Menu $menu */
        foreach ($filteredMenus as $menu) {
            $filteredMenusCount++;
            $filteredMealsCount += count($menu->getMeals());
        }

        $this->assertEquals($expectedMenusCount, $filteredMenusCount);
        $this->assertEquals($expectedMealsCount, $filteredMealsCount);
    }

    private function getMenuRules(int $covers, string $postcode): array
    {
        $coversRule = new MenuCoversMoreThanRule($covers);
        $postcodeRule = new MenuPostcodeRule($postcode);
        return [$coversRule, $postcodeRule];
    }

    private function getMealRules(DateTime $deadline): array
    {
        $mealDeadlineRule = new MealDeliveryDeadlineRule($deadline);
        return [$mealDeadlineRule];
    }
}