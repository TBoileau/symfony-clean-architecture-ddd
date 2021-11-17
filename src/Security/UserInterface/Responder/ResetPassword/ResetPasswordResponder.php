<?php

declare(strict_types=1);

namespace App\Security\UserInterface\Responder\ResetPassword;

use App\Security\UserInterface\ViewModel\ResetPasswordViewModel;
use App\Shared\UserInterface\Responder\TwigResponder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class ResetPasswordResponder implements ResetPasswordResponderInterface
{
    public function __construct(private TwigResponder $decorated, private UrlGeneratorInterface $urlGenerator)
    {
    }

    public function send(ResetPasswordViewModel $viewModel): Response
    {
        return $this->decorated->send('@security/reset_password.html.twig', $viewModel);
    }

    public function redirect(): RedirectResponse
    {
        return new RedirectResponse($this->urlGenerator->generate(''));
    }
}
