<?php

namespace Tests\Unit;

use App\FileCache;
use App\Mocks\CacheDataMock;
use Tests\TestCase;

class FileCacheSetCacheDataTest extends TestCase
{
    private $mock;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->mock = new CacheDataMock();
    }

    /**
     * Checks if data is saved in cache
     *
     * @return void
     */
    public function testIfDataIsSavedInFileCache()
    {
        $fileCache = new FileCache();
        $request = $this->mock->generateData(
            $this->mock->lat,
            $this->mock->long,
            $this->mock->label,
            $this->mock->expires
        );
        $fileCache->setCacheData($request, $this->mock->key);
        $cache = $fileCache->getCacheArray($this->mock->key)[0];

        $this->assertIsObject($cache);
        $this->assertSame($cache->lat, $this->mock->lat);
        $this->assertSame($cache->lng, $this->mock->long);
        $this->assertSame($cache->label, $this->mock->label);
        $this->assertTrue((bool)strtotime($cache->expires));
    }

    /**
     * Checks if cache contains correct count of saved data
     *
     * @return void
     */
    public function testContainsCorrectCountOfSavedData()
    {
        $fileCache = new FileCache();
        $request = $this->mock->generateData(
            $this->mock->lat,
            $this->mock->long,
            $this->mock->label);
        $fileCache->setCacheData($request, $this->mock->key);
        $fileCache->setCacheData($request, $this->mock->key);
        $cache = $fileCache->getCacheArray($this->mock->key);
        $this->assertIsArray($cache);
        $this->assertCount(2, $cache);
    }
}
