<?php

namespace App\Models;

class AdvanceTime
{
    protected $hours;

    private function __construct($hours)
    {
        $this->hours = $hours;
    }

    public static function fromHours(int $hours)
    {
        return new static($hours);
    }

    public function getHours()
    {
        return $this->hours;
    }
}
