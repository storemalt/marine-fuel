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
     * @param string $key
     * @param bool $customExpiration
     * @return bool
     */
    public function setCacheData(Request $request, string $key = 'locations', $customExpiration = false): bool
    {
        if ($request->has('_token')) {
            $data = json_decode($request->current_location, true);
            $data['label'] = $request->location_name;
            $expirationHours = intval($request->duration);

            if (!$customExpiration) {
                $data['expires'] = now()->addHours($expirationHours);
            } else {
                $data['expires'] = $customExpiration;
            }

            // temporarily saved in a file storage
            if (Cache::has($key)) {
                $locations = $this->getCacheArray($key);
                array_push($locations, $data);
                return $this->putCacheForever(json_encode($locations), $key);

            } else {
                $locations[] = $data;
                return $this->putCacheForever(json_encode($locations), $key);
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
     * @param string $key
     * @return string
     */
    public function deleteExpiredCache(string $key = 'locations'): string
    {
        $locations = $this->getCacheArray($key);
        if (empty($locations)) {
            return $this->defaultLocations();
        }

        // extract expired data
        $expiredData = array_filter($locations, function ($location) {
            $expiry = new Carbon($location->expires);
            return $expiry->isPast();
        });

        if (empty($expiredData)) {
            return json_encode($locations);
        }

        $expiredDataKeys = array_keys($expiredData);
        $flippedData = array_flip($expiredDataKeys);

        // remove expired data
        $availableLocations = array_diff_key($locations, $flippedData);

        if (!empty($availableLocations)) {
            $locations = array_values($availableLocations);
        } else {
            $locations = [];
        }

        // save new locations data
        $jsonLocations = json_encode($locations);
        $this->putCacheForever($jsonLocations);

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
