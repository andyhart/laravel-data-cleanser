<?php

namespace Tests\Feature;

use App\DataCleanser\DataCleanser;
use Tests\TestCase;

class DataCleanserTest extends TestCase
{
    protected $cleanser;
    protected $result;

    public function setUp()
    {
        parent::setUp();

        $data = [
            [
                'title' => 'Mr',
                'first_name' => 'Andrew',
                'last_name' => 'Hart',
                'mobile' => '7890123456',
                'email_address' => '   andy-hart-leeds@example.com',
            ],
            [
                'title' => 'mister',
                'first_name' => 'joe',
                'last_name' => 'bloggs',
                'mobile' => '07777 777777',
                'email_address' => 'test@example.com',
            ],
        ];

        $this->cleanser = new DataCleanser($data);
        $this->result = $this->cleanser->analyse();
    }

    public function testFilterExists()
    {
        $this->assertTrue($this->cleanser->hasFilter('mobile_number'));
    }

    public function testTitleFilter()
    {
        $this->assertArrayHasKey('title', $this->result[1]['dirty_data']);
        $this->assertSame('mister', $this->result[1]['dirty_data']['title']['value']);
        $this->assertSame('Mr', $this->result[1]['dirty_data']['title']['suggestion']);
    }

    public function testNameFilter()
    {
        $this->assertTrue(true);
    }

    public function testEmailAddressFilter()
    {
        $this->assertArrayHasKey('email_address', $this->result[0]['dirty_data']);
        $this->assertSame('   andy-hart-leeds@example.com', $this->result[0]['dirty_data']['email_address']['value']);
        $this->assertSame('andyhartleeds@example.com', $this->result[0]['dirty_data']['email_address']['suggestion']);
    }

    public function testMobileNumberFilter()
    {
        $this->assertArrayHasKey('mobile', $this->result[0]['dirty_data']);
        $this->assertSame('7890123456', $this->result[0]['dirty_data']['mobile']['value']);
        $this->assertSame('07890 123456', $this->result[0]['dirty_data']['mobile']['suggestion']);
    }
}
