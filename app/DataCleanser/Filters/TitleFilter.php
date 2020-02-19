<?php

namespace App\DataCleanser\Filters;

class TitleFilter extends Filter
{
    protected $keys = ['title'];
    protected $allowed = ['Master', 'Mr', 'Mrs', 'Miss', 'Ms', 'Dr'];
    protected $replacements = [
        'Mister' => 'Mr',
        'Doctor' => 'Dr',
    ];

    public function isClean()
    {
        return in_array($this->value, $this->allowed);
    }

    public function getSuggestion()
    {
        $value = trim(ucwords(strtolower($this->getValue())));

        if (in_array($value, $this->allowed)) {
            return $value;
        }

        if (array_key_exists($value, $this->replacements)) {
            return $this->replacements[$value];
        }
    }
}
