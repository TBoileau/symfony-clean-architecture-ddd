<?php

/**
 * Copyright (C) Thomas Boileau - All Rights Reserved.
 *
 * This source code is protected under international copyright law.
 * All rights reserved and protected by the copyright holders.
 * This file is confidential and only available to authorized individuals with the
 * permission of the copyright holders. If you encounter this file and do not have
 * permission, please contact the copyright holders and delete this file.
 */

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
