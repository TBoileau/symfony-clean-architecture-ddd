<?php

declare(strict_types=1);

use App\Security\UserInterface\Responder\LoginResponder;
use App\Shared\UserInterface\Responder\TwigResponder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container) {
    $container = $container->services()->defaults()
        ->public()
        ->autoconfigure()
        ->autowire();

    $container
        ->load('App\\Security\\UserInterface\\Controller\\', __DIR__.'/../../../UserInterface/Controller')
        ->tag('controller.service_arguments');

    $container->set(LoginResponder::class)->decorate(TwigResponder::class);
};
