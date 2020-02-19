<?php

namespace App\DataCleanser\Filters;

abstract class Filter
{
    /**
     * Dirtiness score for this filter
     */
    static $dirtiness_score = 10;

    /**
     * Stores the current value the filter is working on cleansing
     */
    protected $value;

    /**
     * Constructor sets the value for the filter
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Gets the currently set value for the filter
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Gets the dirtiness score for the filter
     */
    public function getDirtinessScore()
    {
        return static::$dirtiness_score;
    }

    /**
     * For checking if the filter value is clean
     */
    abstract public function isClean();

    /**
     * For returning a suggested clean value
     */
    abstract public function getSuggestion();
}
