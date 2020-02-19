<?php

namespace App\DataCleanser\Filters;

class EmailAddressFilter extends Filter
{
    /**
     * Just an example of overriding the dirtiness score for a particular filter, if required
     */
    static $dirtiness_score = 25;

    public function isClean()
    {
        // #TODO: Make this more robust to cover more edge cases...
        return preg_match('/[a-zA-Z0-9_]+@[a-zA-Z0-9_.]+/', $this->value);
    }

    public function getSuggestion()
    {
        $value = trim($this->getValue());

        if (!$value) {
            return false;
        }

        $value = preg_replace('/\s+/', '', $value);

        return $value;
    }
}
