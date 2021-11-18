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

namespace App\Security\UserInterface\Responder\Login;

use App\Security\UserInterface\ViewModel\LoginViewModel;
use App\Shared\UserInterface\Responder\TwigResponder;
use Symfony\Component\HttpFoundation\Response;

final class LoginResponder implements LoginResponderInterface
{
    public function __construct(private TwigResponder $decorated)
    {
    }

    public function send(LoginViewModel $loginViewModel): Response
    {
        return $this->decorated->send('@security/login.html.twig', $loginViewModel);
    }
}
