<?php
use League\Container\ServiceProvider;

$serviceProviders = [
    new Semver\Http\Support\RoutesServiceProvider(),
    new Semver\Http\Support\RequestServiceProvider(),
    new Semver\Services\Paths\ServiceProvider(),
    new Semver\Services\Error\ServiceProvider(),
    new Semver\Services\Packagist\ServiceProvider(),
];

// Register the service providers.
array_walk($serviceProviders, function (ServiceProvider $serviceProvider) use ($container) {
    $serviceProvider->setContainer($container);
    $container->add($serviceProvider);
});

// Call the boot methods.
array_walk($serviceProviders, function (ServiceProvider $serviceProvider) use ($container) {
    if (method_exists($serviceProvider, 'boot')) {
        $container->call([$serviceProvider, 'boot']);
    }
});