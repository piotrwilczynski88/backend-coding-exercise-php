<?php

namespace App\Models;

class Meal
{
    /** @var string */
    protected $name;

    /** @var AdvanceTime */
    protected $advanceTime;

    /** @var array */
    protected $allergies = [];

    public function __construct(string $name, AdvanceTime $advanceTime, array $allergies)
    {
        $this->name = $name;
        $this->advanceTime = $advanceTime;
        $this->allergies = $allergies;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return AdvanceTime
     */
    public function getAdvanceTime(): AdvanceTime
    {
        return $this->advanceTime;
    }

    /**
     * @param AdvanceTime $advanceTime
     */
    public function setAdvanceTime(AdvanceTime $advanceTime): void
    {
        $this->advanceTime = $advanceTime;
    }

    /**
     * @return array
     */
    public function getAllergies(): array
    {
        return $this->allergies;
    }

    /**
     * @param array $allergies
     */
    public function setAllergies(array $allergies): void
    {
        $this->allergies = $allergies;
    }
}
