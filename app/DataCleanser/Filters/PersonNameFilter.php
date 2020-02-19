<?php

namespace App\DataCleanser\Filters;

class PersonNameFilter extends Filter
{
    public function isClean()
    {
        return ($this->value == ucfirst($this->value));
    }

    public function getSuggestion()
    {
        return ucfirst($this->value);
    }
}
