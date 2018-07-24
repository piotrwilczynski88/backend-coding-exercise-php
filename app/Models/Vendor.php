<?php

namespace App\Models;

class Vendor
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $postcode;

    /** @var int */
    protected $maxCovers;

    /** @var array */
    protected $menuPositions = [];

    public function __construct($name, $postcode, $maxCovers)
    {
        $this->name = $name;
        $this->postcode = $postcode;
        $this->maxCovers = $maxCovers;
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
     * @return string
     */
    public function getPostcode(): string
    {
        return $this->postcode;
    }

    /**
     * @param string $postcode
     */
    public function setPostcode(string $postcode): void
    {
        $this->postcode = $postcode;
    }

    /**
     * @return int
     */
    public function getMaxCovers(): int
    {
        return $this->maxCovers;
    }

    /**
     * @param int $maxCovers
     */
    public function setMaxCovers(int $maxCovers): void
    {
        $this->maxCovers = $maxCovers;
    }
}
