<?php


namespace App\Mocks;

use Illuminate\Http\Request;

class CacheDataMock
{
    public $expires;
    public $key;
    public $lat;
    public $long;
    public $label;

    public function __construct(
        int $expires = 1,
        string $key = 'testData',
        float $lat = 1.286950,
        float $long = 103.750653,
        string $label = 'Singapore Test location'
    ) {
        $this->expires = $expires;
        $this->key = $key;
        $this->lat = $lat;
        $this->long = $long;
        $this->label = $label;
    }

    /**
     * Mocks request location data for file cache storage
     *
     * @param float $lat
     * @param float $long
     * @param string $label
     * @param int $expires
     * @param string $token
     * @return Request
     */
    public function generateData(
        float $lat = 1.286950,
        float $long = 103.750653,
        string $label = 'Singapore',
        int $expires = 1,
        string $token = null
    ): Request {

        $request = new Request();
        if (empty($token)) {
            $token = bin2hex(openssl_random_pseudo_bytes(5));
        }

        $data = [
            '_token' => $token,
            'current_location' => '{"lat":' . $lat . ',"lng":' . $long . '}',
            'location_name' => $label,
            'duration' => $expires,
        ];

        $request->merge($data);

        return $request;
    }
}
