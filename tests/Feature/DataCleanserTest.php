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
                'mobile' => '7938410155',
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

    public function testFilterDoesntExist()
    {
        $this->expectException('RuntimeException');
        $this->cleanser->cleanseType('nonexistent');
    }

    public function testTitleFilter()
    {
        $this->assertEquals([
            1 => [
                'mobile_number' => [
                    'value' => 'mister',
                    'suggestion' => 'Mr',
                ]
            ]
        ], $this->cleanser->cleanseType('title'));
    }

    public function testNameFilter()
    {
        //
    }

    public function testPostalAddressFilter()
    {
        //
    }

    public function testEmailAddressFilter()
    {
        //
    }

    public function testMobileNumberFilter()
    {
        $this->assertEquals([
            0 => [
                'mobile_number' => [
                    'value' => '7938410155',
                    'suggestion' => '07938 410155',
                ]
            ]
        ], $this->cleanser->cleanseType('mobile_number'));
    }
}
