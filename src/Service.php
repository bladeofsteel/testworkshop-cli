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
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(Client $client = null)
    {
        if (null === $client) {
            $client = new Client();
        }
        $this->client = $client;
    }

    public function fetchWeather(string $city): string
    {
        /** @var \GuzzleHttp\Psr7\Response $response */
        $response = $this->client->request('GET', "https://www.metaweather.com/api/location/search/?query={$city}");
        $data = \json_decode($response->getBody()->getContents(), true)[0];

        /** @var \GuzzleHttp\Psr7\Response $response */
        $response = $this->client->get(
            "https://www.metaweather.com/api/location/{$data['woeid']}/" . date('Y/m/d/', time())
        );
        $weather = \json_decode($response->getBody()->getContents(), true)[0];

        return "{$weather['weather_state_name']} / {$weather['the_temp']} / {$weather['wind_speed']}";
    }
}
