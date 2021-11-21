<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Symfony\Security\Authenticator;

use App\Security\Domain\ValueObject\Password\PlainPassword;
use App\Security\Infrastructure\Symfony\Security\Authenticator\Passport\PasswordCredentials;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

final class Authenticator extends AbstractAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'security_login';

    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    public function supports(Request $request): ?bool
    {
        return $request->isMethod(Request::METHOD_POST) && self::LOGIN_ROUTE === $request->attributes->get('_route');
    }

    public function authenticate(Request $request): PassportInterface
    {
        /**
         * @var string $email
         * @var string $password
         * @var string $csrfToken
         */
        ['email' => $email, 'password' => $password, '_csrf_token' => $csrfToken] = $request->request->all();

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials(PlainPassword::createFromString($password)),
            [
                new CsrfTokenBadge('authenticate', $csrfToken),
                new RememberMeBadge(),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        /** @var ?string $targetPath */
        $targetPath = $this->getTargetPath($request->getSession(), $firewallName);

        if (null !== $targetPath) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate('home'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $request->getSession()->set(
            Security::AUTHENTICATION_ERROR,
            $exception->getPrevious() instanceof AccountStatusException ? $exception->getPrevious() : $exception
        );

        return new RedirectResponse($this->urlGenerator->generate(self::LOGIN_ROUTE));
    }
}
