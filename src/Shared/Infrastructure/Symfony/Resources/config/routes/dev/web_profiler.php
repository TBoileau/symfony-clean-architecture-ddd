<?php

declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes->import('@WebProfilerBundle/Resources/config/routing/wdt.xml')
        ->prefix('/_wdt')
    ;

    $routes->import('@WebProfilerBundle/Resources/config/routing/profiler.xml')
        ->prefix('/_profiler')
    ;
};
