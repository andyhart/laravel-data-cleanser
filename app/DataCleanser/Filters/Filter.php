<?php

namespace App\DataCleanser\Filters;

abstract class Filter
{
    // States which keys in a data array we should use this filter for
    // eg: Names of people might use the keys 'first_name' and 'last_name'
    protected $keys = [];

    // Stores the current value the filter is working on cleansing
    protected $value;

    // Dirtiness score for this filter
    protected $dirtiness_score = 10;

    public function getKeys()
    {
        return $this->keys;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    abstract public function isClean();

    abstract public function getSuggestion();
}
