<?php

declare(strict_types=1);

namespace App\Security\UserInterface\Responder\Login;

use App\Security\UserInterface\ViewModel\LoginViewModel;
use Symfony\Component\HttpFoundation\Response;

interface LoginResponderInterface
{
    public function send(LoginViewModel $loginViewModel): Response;
}
