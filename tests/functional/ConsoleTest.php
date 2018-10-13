<?php

namespace TestWorkshop\Test\Weather;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class ConsoleTest extends \Codeception\Test\Unit
{
    /**
     * @var \TestWorkshop\Test\FunctionalTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $mock = new MockHandler(
            [
                new Response(
                    200,
                    ['Content-Type' => 'application/json; charset=utf-8'],
                    \file_get_contents(__DIR__ . '/../_data/location.json')
                ),
                new Response(
                    200,
                    ['Content-Type' => 'application/json; charset=utf-8'],
                    \file_get_contents(__DIR__ . '/../_data/weather.json')
                ),
            ]
        );
        $stack = HandlerStack::create($mock);

        $client = new Client(['handler' => $stack]);

        $container = new \League\Container\Container();
        $container->share(\GuzzleHttp\Client::class, $client);

        \TestWorkshop\Weather\Bootstrap::init($container);
        /** @var \TestWorkshop\Weather\Console $console */
        $console = $container->get(\TestWorkshop\Weather\Console::class);
        $result = $console->execute();
        $this->assertEquals('Showers / 20.52 / 12.712062191291', $result);
    }
}
