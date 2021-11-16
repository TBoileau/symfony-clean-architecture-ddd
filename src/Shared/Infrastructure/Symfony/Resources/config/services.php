<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container) {
    $container = $container->services()->defaults()
        ->public()
        ->autoconfigure()
        ->autowire();

    $container
        ->load('App\\Shared\\', __DIR__.'/../../../../')
        ->exclude([
            __DIR__.'/../',
            __DIR__.'/../../../../Domain/ValueObject',
            __DIR__.'/../../../../Domain/Tests',
        ]);
};
