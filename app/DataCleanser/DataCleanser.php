<?php

namespace App\DataCleanser;

use RuntimeException;

class DataCleanser
{
    protected $data = [];

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function hasFilter($filter_name)
    {
        return class_exists($this->convertFilterNameToClassName($filter_name));
    }

    /**
     * Cleanses one individual type of data.
     */
    public function cleanseType($filter_name)
    {
        if (!$this->hasFilter($filter_name)) {
            throw new RuntimeException('No filter is available to cleanse data type "' . $filter_name . '"');
        }

        $class_name = $this->convertFilterNameToClassName($filter_name);
        $filter = new $class_name;

        $results = [];

        if ($filter_keys = $filter->getKeys()) {
            // Loop through our data rows to look for matching keys this filter can cleanse
            foreach ($this->data as $index => $row) {
                foreach ($filter_keys as $key) {
                    if (array_key_exists($key, $row)) {
                        $filter->setValue($row[$key]);

                        if (!$filter->isClean()) {
                            $results[$index][$filter_name] = [
                                'value' => $row[$key],
                                'suggestion' => $filter->getSuggestion(),
                            ];
                        }
                    }
                }
            }
        }

        dump($results);
        return $results;
    }

    private function convertFilterNameToClassName($filter_name)
    {
        return __NAMESPACE__ . '\Filters\\' . studly_case($filter_name) . 'Filter'::class;
    }
}
