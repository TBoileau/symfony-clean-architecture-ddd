<?php

declare(strict_types=1);

use Symfony\Bundle\FrameworkBundle\Controller\TemplateController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes
        ->add('home', '/')
        ->controller(sprintf('%s::templateAction', TemplateController::class))
        ->defaults(['template' => 'home.html.twig'])
    ;
};
