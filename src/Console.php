<?php declare(strict_types=1);

namespace TestWorkshop\Weather;

use League\CLImate\CLImate;

class Console
{
    /**
     * @var \League\CLImate\CLImate
     */
    private $climate;
    /**
     * @var \TestWorkshop\Weather\Service
     */
    private $service;

    /**
     * Console constructor.
     *
     * @param \League\CLImate\CLImate       $climate
     * @param \TestWorkshop\Weather\Service $service
     *
     * @throws \Exception
     */
    public function __construct(CLImate $climate, Service $service)
    {
        $this->climate = $climate;
        $this->service = $service;
        $climate->arguments->add(
            [
                'location' => [
                    'description' => 'Location name',
                ],
            ]
        );
    }

    public function execute()
    {
        $this->climate->arguments->parse();
        $location = $this->climate->arguments->get('location');

        $data = $this->service->fetchWeather($location, time());
        $weather = $data[0];
        return "{$weather['weather_state_name']} / {$weather['the_temp']} / {$weather['wind_speed']}";
    }
}
