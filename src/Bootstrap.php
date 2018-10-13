<?php declare(strict_types=1);

namespace TestWorkshop\Weather;

use League\CLImate\CLImate;
use League\Container\Container;

class Bootstrap
{
    /**
     * @param \League\Container\Container|null $container
     *
     * @return \League\Container\Container
     */
    public static function init(Container $container = null): Container
    {
        if (null === $container) {
            $container = new Container();
        }

        $container->share(
            Console::class,
            function () use ($container) {
                return new Console($container->get(CLImate::class), $container->get(Service::class));
            }
        );
        $container->share(
            Service::class,
            function () use ($container) {
                return new Service($container->get(\GuzzleHttp\Client::class));
            }
        );
        $container->share(
            \GuzzleHttp\Client::class,
            function () {
                return new \GuzzleHttp\Client();
            }
        );
        $container->share(CLImate::class);

        return $container;
    }
}
