<?php

declare(strict_types=1);

namespace App\Security\UserInterface\Controller;

use App\Security\UserInterface\Responder\LoginResponderInterface;
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
