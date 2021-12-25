<?php

namespace App\Services;

use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Support\Facades\Http;

/**
 * Class OpenWeatherMapService
 */
class OpenWeatherMapService
{
    /**
     * @var string
     */
    private $apiUrl;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * OpenWeatherMapService constructor.
     * @param string $apiUrl
     * @param string $apiKey
     */
    public function __construct(string $apiUrl, string $apiKey)
    {
        $this->apiUrl = $apiUrl;
        $this->apiKey = $apiKey;
    }

    /**
     * @param array $params
     * @param string|null $key
     * @param string|null $default
     * @return array
     */
    public function getJson(array $params = [], string $key = null, string $default = null): array
    {
        $response = $this->get($params);

        return [
            'success' => $response->successful(),
            'status' => $response->status(),
            'data' => $response->json($key,$default),
        ];
    }

    /**
     * @param array $params
     * @return ClientResponse
     */
    private function get(array $params): ClientResponse
    {
        $params = array_merge(['appid' => $this->apiKey], $params);

        return Http::get($this->apiUrl,$params);
    }
}
