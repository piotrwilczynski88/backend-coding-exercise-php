<?php

namespace App\tests\Unit\Rules;

use App\Models\Menu;
use App\Models\Vendor;
use App\Rules\MenuPostcodeRule;
use PHPUnit\Framework\TestCase;

class MenuPostcodeRuleTest extends TestCase
{
    public function testPasses(): void
    {
        $rule = new MenuPostcodeRule('ABCDEF');
        $menu = new Menu(new Vendor('restaurant', 'AB1234', 12));
        $rule->validate($menu);
        $this->assertTrue($rule->validate($menu));
    }
    public function testFails(): void
    {
        $rule = new MenuPostcodeRule('ABCDEF');
        $menu = new Menu(new Vendor('restaurant', 'A1CDEF', 12));
        $rule->validate($menu);
        $this->assertFalse($rule->validate($menu));
    }
}