<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileCacheDeleteExpiredCacheTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $fileCache = new FileCache();
        $fileCache->deleteExpiredCache();
        $this->assertTrue(true);
    }
}
