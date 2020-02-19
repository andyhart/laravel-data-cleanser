<?php

namespace App\DataCleanser\Filters;

abstract class Filter
{
    /**
     * States which keys in a data array we should use this filter for
     * eg: Names of people might use the keys 'first_name' and 'last_name'
     */
    protected $keys = [];

    /**
     * Stores the current value the filter is working on cleansing
     */
    protected $value;

    /**
     * Dirtiness score for this filter
     */
    protected $dirtiness_score = 10;

    /**
     * Gets all keys that this filter can check for to cleanse
     * 
     * @return bool
     */
    public function getKeys()
    {
        return $this->keys;
    }

    /**
     * Sets the value for the filter
     */
    public function setValue($value)
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
     * For checking if the filter value is clean
     */
    abstract public function isClean();

    /**
     * For returning a suggested clean value
     */
    abstract public function getSuggestion();
}
