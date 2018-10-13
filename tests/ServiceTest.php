<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{

    public function testShouldReturnWeatherInLondonAsString()
    {
        $client = $this->prepareHttpClient();

        $service = new \TestWorkshop\Weather\Service($client);

        $result = $service->fetchWeather('london');
        $this->assertEquals('Showers / 20.52 / 12.712062191291', $result);
    }

    /**
     * @return \GuzzleHttp\Client
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    private function prepareHttpClient(): \GuzzleHttp\Client
    {
        return new Client(
            [
                'handler' => HandlerStack::create(
                    new MockHandler(
                        [
                            new Response(
                                200,
                                ['Content-Type' => 'application/json; charset=utf-8'],
                                \file_get_contents(__DIR__ . '/_data/location.json')
                            ),
                            new Response(
                                200,
                                ['Content-Type' => 'application/json; charset=utf-8'],
                                \file_get_contents(__DIR__ . '/_data/weather.json')
                            ),
                        ]
                    )
                ),
            ]
        );
    }
}
