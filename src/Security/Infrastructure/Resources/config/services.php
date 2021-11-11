<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container) {
    $container = $container->services()->defaults()
        ->public()
        ->autoconfigure()
        ->autowire();

    $container
        ->load('App\\Security\\', __DIR__.'/../../../')
        ->exclude([
            __DIR__.'/../../Resources',
            __DIR__.'/../../../Domain/ValueObject',
            __DIR__.'/../../../Domain/Entity',
            __DIR__.'/../../Model',
        ]);

    $container
        ->load('App\\Security\\UserInterface\\Controller\\', __DIR__.'/../../../UserInterface/Controller')
        ->tag('controller.service_arguments');
};
