<?php

namespace Tests\Unit;

use App\FileCache;
use App\Mocks\CacheDataMock;
use Tests\TestCase;

class FileCacheDeleteExpiredCacheTest extends TestCase
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
    public function testIfDataIsDeletedInFileCache()
    {
        $fileCache = new FileCache();
        $request = $this->mock->generateData($this->mock->lat, $this->mock->long, $this->mock->label);
        $fileCache->setCacheData($request, $this->mock->key, now()->subSecond());
        $locations = $fileCache->deleteExpiredCache($this->mock->key);
        $this->assertEmpty(json_decode($locations));
    }

    /**
     * Checks if cache contains correct count after a deletion
     *
     * @return void
     */
    public function testContainsCorrectCountAfterDeletion()
    {
        $fileCache = new FileCache();
        $request = $this->mock->generateData($this->mock->lat, $this->mock->long, $this->mock->label);
        $fileCache->setCacheData($request, $this->mock->key, now()->subSecond());
        $fileCache->setCacheData($request, $this->mock->key);
        $locations = $fileCache->deleteExpiredCache($this->mock->key);
        $this->assertIsString($locations);
        $this->assertCount(1, json_decode($locations));
    }
}
