<?php

namespace Tests\Feature;

use App\DataCleanser\DataCleanser;
use App\DataCleanser\Filters\TitleFilter;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DataCleanserTest extends TestCase
{
    protected $cleanser;

    public function setUp()
    {
        parent::setUp();

        $data = [
            [
                'title' => 'Mr',
                'first_name' => 'Andrew',
                'last_name' => 'Hart',
                'mobile' => '7890123456',
            ],
            [
                'title' => 'mister',
                'first_name' => 'joe',
                'last_name' => 'bloggs',
                'mobile' => '07777 777777',
            ]
        ];

        $this->cleanser = new DataCleanser($data);
    }

    public function testFilterExists()
    {
        $this->assertTrue($this->cleanser->hasFilter('mobile_number'));
    }

    public function testTitleFilter()
    {
        $this->assertArraySubset([
            1 => [
                'title' => [
                    'value' => 'mister',
                    'suggestion' => 'Mr',
                ]
            ]
        ], $this->cleanser->analyse());
    }

    public function testNameFilter()
    {
        $this->assertTrue(true);
    }

    public function testPostalAddressFilter()
    {
        $this->assertTrue(true);
    }

    public function testEmailAddressFilter()
    {
        $this->assertTrue(true);
    }

    public function testMobileNumberFilter()
    {
        $this->assertArraySubset([
            0 => [
                'mobile' => [
                    'value' => '7890123456',
                    'suggestion' => '07890 123456',
                ]
            ]
        ], $this->cleanser->analyse());
    }
}
