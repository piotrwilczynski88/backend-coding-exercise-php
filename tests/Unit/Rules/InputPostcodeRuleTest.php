<?php

namespace App\tests\Unit\Rules;

use App\Rules\InputCoversRule;
use App\Rules\InputPostcodeRule;
use PHPUnit\Framework\TestCase;

class InputPostcodeRuleTest extends TestCase
{
    public function testRule()
    {
        // TODO: InputPostcodeRule needs additional validation
        $rule = new InputPostcodeRule();

        $valid = ['ABCDEF', 'AB3DEF7', 'ABCDEFGH', 123456];
        $invalid = ['ABC', 123, 'ABCDEFGHIJKLM'];

        foreach ($valid as $checkedValue) {
            $this->assertTrue($rule->validate($checkedValue));
        }

        foreach ($invalid as $checkedValue) {
            $this->assertFalse($rule->validate($checkedValue));
        }
    }
}