<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Symfony\Security\EntryPoint;

use App\Security\Infrastructure\Symfony\Security\Authenticator\Authenticator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

final class AuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    public function start(Request $request, ?AuthenticationException $authException = null): Response
    {
        if (null !== $authException) {
            $request->getSession()->set(Security::AUTHENTICATION_ERROR, $authException);
        }

        return new RedirectResponse($this->urlGenerator->generate(Authenticator::LOGIN_ROUTE));
    }
}
