<?php

namespace Tests\Unit\Rules;

use App\Models\Menu;
use App\Models\Vendor;
use App\Rules\MenuCoversMoreThanRule;
use Tests\TestCase;

class MenuCoversMoreThanRuleTest extends TestCase
{
    public function testPasses(): void
    {
        $rule = new MenuCoversMoreThanRule(12);
        $menu = new Menu(new Vendor('restaurant', 'ABCDEF', 13));
        $rule->validate($menu);
        $this->assertTrue($rule->validate($menu));
    }

    public function testPassesOnEquals(): void
    {
        $rule = new MenuCoversMoreThanRule(12);
        $menu = new Menu(new Vendor('restaurant', 'ABCDEF', 12));
        $rule->validate($menu);
        $this->assertTrue($rule->validate($menu));
    }

    public function testFails(): void
    {
        $rule = new MenuCoversMoreThanRule(12);
        $menu = new Menu(new Vendor('restaurant', 'ABCDEF', 11));
        $this->assertFalse($rule->validate($menu));
    }
}