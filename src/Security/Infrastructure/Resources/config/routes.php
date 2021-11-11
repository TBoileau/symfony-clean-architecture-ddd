<?php

declare(strict_types=1);

use App\Security\UserInterface\Controller\LoginController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes
        ->collection('security')
            ->prefix('/security')
                ->add('_login', '/login')->controller(LoginController::class)
                ->add('_logout', '/logout')
    ;
};
