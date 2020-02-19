<?php

namespace App\DataCleanser\Filters;

use ErrorException;

class UKPostcodeFilter extends Filter
{
    protected $api_endpoint = "http://api.postcodes.io/postcodes/";
    protected $api_response;
    protected $postcode;

    public function __construct($value)
    {
        parent::__construct($value);

        // #TODO: Don't use lazy file_get_contents - maybe use Guzzle or something instead...
        $this->postcode = preg_replace('/[^A-Za-z0-9 ]/', '', trim($this->value));

        try {
            $response = file_get_contents($this->api_endpoint . $this->postcode);
            $this->api_response = json_decode($response);
        } catch (ErrorException $e) {
            // #TODO: Some sort of additional postcode invalid logic/error here...
        }
    }

    public function isClean()
    {
        if (!$this->api_response) {
            return false;
        }

        if ($this->api_response->result->postcode == $this->postcode) {
            return true;
        }

        return false;
    }

    public function getSuggestion()
    {
        return $this->api_response
            ? $this->api_response->result->postcode 
            : false;
    }
}
