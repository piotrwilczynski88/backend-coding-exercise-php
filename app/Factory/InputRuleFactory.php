<?php

namespace App\Factory;

use App\Rules\IInputValidationRule;
use App\Rules\InputCoversRule;
use App\Rules\InputDateRule;
use App\Rules\InputTimeRule;

class InputRuleFactory
{
    /**
     * @return IInputValidationRule|null
     */
    public static function build(string $rule)
    {
        if ('time' === $rule) {
            return new InputTimeRule();
        }
        if ('day' === $rule) {
            return new InputDateRule();
        }
        if ('covers' === $rule) {
            return new InputCoversRule();
        }

        return null;
    }
}
