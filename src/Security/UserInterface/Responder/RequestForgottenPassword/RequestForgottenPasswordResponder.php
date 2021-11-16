<?php

declare(strict_types=1);

namespace App\Security\UserInterface\Responder\RequestForgottenPassword;

use App\Security\UserInterface\ViewModel\RequestForgottenPasswordViewModel;
use App\Shared\UserInterface\Responder\TwigResponder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class RequestForgottenPasswordResponder implements RequestForgottenPasswordResponderInterface
{
    public function __construct(private TwigResponder $decorated, private UrlGeneratorInterface $urlGenerator)
    {
    }

    public function send(RequestForgottenPasswordViewModel $viewModel): Response
    {
        return $this->decorated->send('@security/request_forgotten_password.html.twig', $viewModel);
    }

    public function redirect(): RedirectResponse
    {
        return new RedirectResponse($this->urlGenerator->generate('security_login'));
    }
}
