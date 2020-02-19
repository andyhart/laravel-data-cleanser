<?php

namespace App\DataCleanser\Filters;

class MobileNumberFilter extends Filter
{
    protected $keys = ['mobile', 'mobile_number'];

    public function isClean()
    {
        return preg_match('/0[0-9]{4}\s[0-9]{6}/', $this->value);
    }

    public function getSuggestion()
    {
        $value = $this->getValue();

        // Remove non-numeric characters
        $value = preg_replace('/[^0-9]/', '', $value);

        // Add leading zero if missing
        if (substr($value, 0, 1) != 0) {
            $value = '0' . $value;
        }

        // Ensure correct formatting
        $value = substr($value, 0, 5) . ' ' . substr($value, 5);

        return $value;
    }
}
