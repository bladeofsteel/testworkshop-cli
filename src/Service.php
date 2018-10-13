<?php declare(strict_types=1);

namespace TestWorkshop\Weather;

use GuzzleHttp\Client;

class Service
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * Service constructor.
     *
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function fetchWeather(string $city, int $date)
    {
        /** @var \GuzzleHttp\Psr7\Response $response */
        $response = $this->client->request('GET', "https://www.metaweather.com/api/location/search/?query={$city}");
        $data = \json_decode($response->getBody()->getContents(), true)[0];

        /** @var \GuzzleHttp\Psr7\Response $response */
        $response = $this->client->get(
            "https://www.metaweather.com/api/location/{$data['woeid']}/" . date('Y/m/d/', $date)
        );

        return \json_decode($response->getBody()->getContents(), true);
    }
}
