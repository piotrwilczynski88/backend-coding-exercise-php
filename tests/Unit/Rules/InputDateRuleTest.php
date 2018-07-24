<?php

namespace App\tests\Unit\Rules;

use App\Rules\InputDateRule;
use PHPUnit\Framework\TestCase;

class InputDateRuleTest extends TestCase
{
    public function testRule()
    {
        $rule = new InputDateRule();

        $valid = ['25/07/18', '01/01/01', '31/12/99'];
        $invalid = ['', ' ', '25\07\18', '07/25/18', '25.07.19', '5/1/11', '45/01/99'];

        foreach ($valid as $checkedValue) {
            $this->assertTrue($rule->validate($checkedValue));
        }

        foreach ($invalid as $checkedValue) {
            $this->assertFalse($rule->validate($checkedValue));
        }

    }
}