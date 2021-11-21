<?php

declare(strict_types=1);

use App\Security\Infrastructure\Symfony\Security\Authenticator\Authenticator;
use App\Security\Infrastructure\Symfony\Security\EntryPoint\AuthenticationEntryPoint;
use App\Security\Infrastructure\Symfony\Security\User\Checker;
use App\Security\Infrastructure\Symfony\Security\User\Provider;
use Symfony\Config\SecurityConfig;

return static function (SecurityConfig $security): void {
    $security->enableAuthenticatorManager(true);

    $security->provider('security_provider')->id(Provider::class);

    $security->firewall('dev')
        ->pattern('^/(_(profiler|wdt)|css|images|js)/')
        ->security(false);

    $security->firewall('main')
        ->lazy(true)
        ->pattern('^/')
        ->provider('security_provider')
        ->userChecker(Checker::class)
        ->entryPoint(AuthenticationEntryPoint::class)
        ->customAuthenticators([Authenticator::class])
        ->logout()
            ->path('security_logout');

    $security->accessControl()->path('^/security')->roles(['PUBLIC_ACCESS']);
    $security->accessControl()->path('^/')->roles(['ROLE_USER']);
};
