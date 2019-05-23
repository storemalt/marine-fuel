<?php

namespace Tests\Unit;

use App\FileCache;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileCacheSetCacheDataTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testIfDataIsSavedInFileCache()
    {
        $request = new Request();
        $key = 'test';
        $lat = 3.1560780999999998;
        $lng = 101.7239218;
        $label = 'Test Location Name';
        $data = [
            '_token' => 'asdfa098s7das54dfa98s6df9',
            'current_location' => '{"lat":' . $lat . ',"lng":' . $lng . '}',
            'location_name' => $label,
            'duration' => 1,
        ];

        $request->merge($data);
        $fileCache = new FileCache();
        $fileCache->setCacheData($request, $key);
        $cache = $fileCache->getCacheArray($key)[0];

        $this->assertIsObject($cache);
        $this->assertSame($cache->lat, $lat);
        $this->assertSame($cache->lng, $lng);
        $this->assertSame($cache->label, $label);
        $this->assertTrue((bool)strtotime($cache->expires));
    }
}
