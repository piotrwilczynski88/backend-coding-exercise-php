<?php

namespace App\Rules;

use App\Models\Meal;
use DateInterval;
use DateTime;
use Exception;

class MealDeliveryDeadlineRule implements IMealRule
{
    /** @var DateTime */
    protected $deadline;

    public function __construct(DateTime $deadline)
    {
        $this->deadline = $deadline;
    }

    /**
     * @throws Exception
     */
    public function validate(Meal $meal): bool
    {
        $minDelivery = new DateTime();
        $minDelivery->add(new DateInterval('PT' . $meal->getAdvanceTime()->getHours() . 'H'));

        return $this->deadline->getTimestamp() - $minDelivery->getTimestamp() >= 0;
    }
}
