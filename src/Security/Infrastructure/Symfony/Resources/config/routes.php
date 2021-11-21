<?php

declare(strict_types=1);

use App\Security\UserInterface\Controller\LoginController;
use App\Security\UserInterface\Controller\RequestForgottenPasswordController;
use App\Security\UserInterface\Controller\ResetPasswordController;
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
                    ->controller(ResetPasswordController::class)
                    ->methods([Request::METHOD_GET, Request::METHOD_POST])
                    ->requirements([
                        'token' => '^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-4[0-9A-Fa-f]{3}-[89ABab][0-9A-Fa-f]{3}-[0-9A-Fa-f]{12}$',
                    ])
    ;
};
