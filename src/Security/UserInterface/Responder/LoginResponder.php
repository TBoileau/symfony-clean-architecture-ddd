<?php

declare(strict_types=1);

namespace App\Security\UserInterface\Responder;

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
