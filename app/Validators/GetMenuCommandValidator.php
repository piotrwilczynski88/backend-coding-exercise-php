<?php

namespace App\Validators;

use App\Exceptions\ValidationException;
use App\Factory\InputRuleFactory;
use Symfony\Component\Console\Input\InputInterface;

class GetMenuCommandValidator implements IInputValidator
{
    /**
     * @throws ValidationException
     */
    public function validate(InputInterface $input)
    {
        foreach ($input->getArguments() as $argumentName => $value) {
            $rule = InputRuleFactory::build($argumentName);
            if (null === $rule) {
                continue;
            }
            if (!$rule->validate($value)) {
                throw new ValidationException($argumentName);
            }
        }

        return true;
    }
}
