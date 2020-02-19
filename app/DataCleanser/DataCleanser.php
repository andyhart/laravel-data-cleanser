<?php

namespace App\DataCleanser;

use RuntimeException;

class DataCleanser
{
    protected $data = [];

    protected $filters = [
        'title' => Filters\TitleFilter::class,
        'first_name' => Filters\PersonNameFilter::class,
        'last_name' => Filters\PersonNameFilter::class,
        'mobile' => Filters\MobileNumberFilter::class,
        'mobile_number' => Filters\MobileNumberFilter::class,
        'email' => Filters\EmailAddressFilter::class,
        'email_address' => Filters\EmailAddressFilter::class,
    ];

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * Allows filters to be overridden
     * Provide as key/value pairs with the filter name as the key and the filter class as the value
     * 
     * @param array $filters
     * @return object
     */
    public function setFilters($filters = []): DataCleanser
    {
        $this->filters = $filters;
        return $this;
    }

    /**
     * Check if we have a filter class for a particular data type
     * 
     * @param string $filter_name
     * @return bool
     */
    public function hasFilter($filter_name): bool
    {
        return array_key_exists($filter_name, $this->filters);
    }

    /**
     * Analyses data and returns a report of unclean values, dirtiness scores as well as suggestions
     * 
     * @return array
     */
    public function analyse(): array
    {
        $results = [];

        // Loop through our data rows to look for matching keys this filter can cleanse
        foreach ($this->data as $index => $row) {
            // Set up our results array for this row
            $results[$index] = [
                'dirty_data' => [],
                'overall_dirtiness_score' => 0,
            ];

            foreach ($row as $key => $value) {
                if (array_key_exists($key, $this->filters)) {
                    $filter = new $this->filters[$key];
                    $filter->setValue($value);

                    if (!$filter->isClean()) {
                        $results[$index]['overall_dirtiness_score'] += $filter->getDirtinessScore();
                        $results[$index]['dirty_data'][$key] = [
                            'value' => $value,
                            'suggestion' => $filter->getSuggestion(),
                            'dirtiness_score' => $filter->getDirtinessScore(),
                        ];
                    }
                }
            }
        }

        return $results;
    }
}
