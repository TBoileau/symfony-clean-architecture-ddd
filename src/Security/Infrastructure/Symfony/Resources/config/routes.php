<?php

declare(strict_types=1);

use App\Security\UserInterface\Controller\LoginController;
use App\Security\UserInterface\Controller\RequestForgottenPasswordController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes
        ->collection('security')
            ->prefix('/security')
                ->add('_login', '/login')
                    ->controller(LoginController::class)
                ->add('_logout', '/logout')
                ->add('_request_forgotten_password', '/request-forgotten-password')
                    ->controller(RequestForgottenPasswordController::class)
                    ->methods([Request::METHOD_GET, Request::METHOD_POST])
                ->add('_reset_password', '/reset-password/{token}')
                    ->requirements([
                        'token' => '^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$',
                    ])
    ;
};
