<?php
declare(strict_types=1);

namespace App;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FileCache
{
    /**
     * Get cached locations as an array
     *
     * @param string $key
     * @return array
     */
    public function getCacheArray(string $key = 'locations'): array
    {
        $cacheData = Cache::get($key);
        if (empty($cacheData)) {
            return [];
        }

        return json_decode($cacheData);
    }

    /**
     * Process locations data and saves in file cache
     *
     * @param Request $request
     */
    public function setCacheData(Request $request): void
    {
        if ($request->has('_token')) {
            $data = json_decode($request->current_location, true);
            $data['label'] = $request->location_name;
            $expirationHours = intval($request->duration);
            $data['expires'] = now()->addHours($expirationHours);

            // temporarily saved in a file storage
            if (Cache::has('locations')) {
                $locations = $this->getCacheArray();
                array_push($locations, $data);
                $this->putCacheForever(json_encode($locations));

            } else {
                $locations[] = $data;
                $this->putCacheForever(json_encode($locations));
            }
        }
    }

    /**
     * Stores cache with no expiration
     *
     * @param string $locations
     * @param string $key
     * @return bool
     */
    public function putCacheForever(string $locations, string $key = 'locations')
    {
        return Cache::forever($key, $locations);
    }

    /**
     * Deletes expired data from locations cache
     *
     * @return string
     */
    public function deleteExpiredCache(): string
    {
        $locations = $this->getCacheArray();
        if (empty($locations)) {
            return $this->defaultLocations();
        }

        $expiredData = array_filter($locations, function ($location) {
            $expiry = new Carbon($location->expires);
            return $expiry->isPast();
        });

        if (empty($expiredData)) {
            return json_encode($locations);
        }

        $expiredDataKeys = array_keys($expiredData);
        $flippedData = array_flip($expiredDataKeys);
        $availableLocations = array_diff_key($locations, $flippedData);
        $locations = array_values($availableLocations);

        if (!empty($availableLocations)) {
            $locations = array_values($availableLocations);
        }

        $jsonLocations = json_encode($locations);
        $this->putCacheForever($jsonLocations);

        if (empty($locations)) {
            return $this->defaultLocations();
        }

        return $jsonLocations;
    }

    /**
     * Sets a default location data
     *
     * @return false|string
     */
    public function defaultLocations()
    {
        return json_encode([]);
    }
}
