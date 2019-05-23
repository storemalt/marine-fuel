<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoutingTest extends TestCase
{
    /**
     * Checks Home page route if working
     *
     * @return void
     */
    public function testHomeRouteWorking()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Checks Frequency/Occurrence page route if not broken
     *
     * @return void
     */
    public function testFrequencyPageWorking()
    {
        $response = $this->get('/home/occurrence');
        $response->assertStatus(200);
    }

    /**
     * Checks Unique String page route if working
     *
     * @return void
     */
    public function testUniqueStringPageWorking()
    {
        $response = $this->get('/home/unique-string');
        $response->assertStatus(200);
    }

    /**
     * Check Frequency/Occurrence page route
     *
     * @return void
     */
    public function testPinpointMappingPageWorking()
    {
        $response = $this->get('/home/pinpoint-map');
        $response->assertStatus(200);
    }
}
