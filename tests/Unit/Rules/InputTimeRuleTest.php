<?php

namespace Tests\Unit\Rules;

use App\Rules\InputTimeRule;
use Tests\TestCase;

class InputTimeRuleTest extends TestCase
{
    public function testRule()
    {
        $rule = new InputTimeRule();

        $valid = ['12:23', '00:00', '23:59', '00:10'];
        $invalid = ['1:23', '55:22', '22:77', '223:33', '22:333', '22022', '1:1 '];

        foreach ($valid as $checkedValue) {
            $this->assertTrue($rule->validate($checkedValue));
        }

        foreach ($invalid as $checkedValue) {
            $this->assertFalse($rule->validate($checkedValue));
        }
    }
}