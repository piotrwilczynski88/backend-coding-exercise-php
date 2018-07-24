<?php

namespace App\tests\Unit\Rules;

use App\Rules\InputCoversRule;
use PHPUnit\Framework\TestCase;

class InputCoversRuleTest extends TestCase
{
    public function testRule()
    {
        $rule = new InputCoversRule();

        $valid = [1,5,100];
        $invalid = [-1, 0, 3.14159, 'abc', '', '4h', 'd5'];

        foreach ($valid as $checkedValue) {
            $this->assertTrue($rule->validate($checkedValue));
        }

        foreach ($invalid as $checkedValue) {
            $this->assertFalse($rule->validate($checkedValue));
        }
    }
}