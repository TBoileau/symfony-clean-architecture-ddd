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

namespace App\Security\UserInterface\Controller;

use App\Security\UserInterface\Responder\Login\LoginResponderInterface;
use App\Security\UserInterface\ViewModel\LoginViewModel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class LoginController
{
    public function __invoke(AuthenticationUtils $authenticationUtils, LoginResponderInterface $responder): Response
    {
        return $responder->send(
            new LoginViewModel(
                $authenticationUtils->getLastUsername(),
                $authenticationUtils->getLastAuthenticationError()
            )
        );
    }
}
