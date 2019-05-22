<?php
declare(strict_types=1);

namespace App;


use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class FileCache
{
    public function getCacheArray(string $key = 'locations'): array
    {
        $cacheData = Cache::get($key);
        if (empty($cacheData)) {
            return [];
        }

        return json_decode($cacheData);
    }

    public function getCacheJson(string $key = 'locations'): string
    {
        $cacheData = Cache::get($key);
        return $cacheData;
    }

    public function putCacheForever(string $locations, string $key = 'locations')
    {
        return Cache::forever($key, $locations);
    }

    public function deleteExpiredCache(): string
    {
        $locations = $this->getCacheArray();
        if (empty($locations)) {
            return $this->defaultLocations();
        }

        $expiredData = array_filter($locations, function ($location) {
            $expiry = new Carbon($location->expires);
            $now = Carbon::now()->addHours(1);
            return $now->greaterThan($expiry);
//            return $expiry->isPast();
        });

        if (empty($expiredData)) {
            return json_encode($locations);
        }

        $expiredDataKeys = array_keys($expiredData);
        $flippedData = array_flip($expiredDataKeys);
        $availableLocations = array_diff_key($locations, $flippedData);

        $locationsData = [];
        if (!empty($availableLocations)) {
            // @TODO: ADRIAN debug availableLocations
            array_push($locationsData, $availableLocations);
        }

        $jsonLocationData = json_encode($locationsData);

        // @TODO: ADRIAN fix array has only objects [{}] not [1:{}] upon deletion of one value
        // [
            //  {"1":
            //      {"lat":3.4130581,"lng":101.5918356,"label":"Ship B","expires":"2019-05-22T09:55:14.607930Z"}
            //  }
        //  ]
        // vs [{"lat":3.3130581,"lng":101.5918356,"label":"Ship A","expires":"2019-05-22T08:55:01.614535Z"}]
        $this->putCacheForever($jsonLocationData);

        if (empty($jsonLocationData)) {
            return $this->defaultLocations();
        }

        return $jsonLocationData;
    }

    public function defaultLocations()
    {
        $locations[] = [
            "lat" => 3.108864,
            "lng" => 101.58735360000001,
            "label" => "Ship 0"
        ];
        return json_encode($locations);
    }
}
