<?php

namespace Tests\Unit\Rules;

use App\Models\AdvanceTime;
use App\Models\Meal;
use App\Rules\MealDeliveryDeadlineRule;
use DateInterval;
use DateTime;
use Tests\TestCase;

class MealDeliveryDeadlineRuleTest extends TestCase
{
    public function testPasses(): void
    {
        $deadline = new DateTime();
        $deadline->add(new DateInterval('PT12H'));

        $rule = new MealDeliveryDeadlineRule($deadline);

        $simpleMeal = new Meal('compicated meal', AdvanceTime::fromHours(3), []);

        $this->assertTrue($rule->validate($simpleMeal));
    }

    public function testPassesOnEqualTime(): void
    {
        $deadline = new DateTime();
        $deadline->add(new DateInterval('PT12H'));

        $rule = new MealDeliveryDeadlineRule($deadline);

        $simpleMeal = new Meal('compicated meal', AdvanceTime::fromHours(12), []);

        $this->assertTrue($rule->validate($simpleMeal));
    }

    public function testFails(): void
    {
        $deadline = new DateTime();
        $deadline->add(new DateInterval('PT12H'));

        $rule = new MealDeliveryDeadlineRule($deadline);

        $simpleMeal = new Meal('compicated meal', AdvanceTime::fromHours(24), []);

        $this->assertFalse($rule->validate($simpleMeal));
    }
}