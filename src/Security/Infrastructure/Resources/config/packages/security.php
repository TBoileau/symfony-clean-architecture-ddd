<?php

declare(strict_types=1);

use App\Security\Infrastructure\UserProvider\UserProvider;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Config\SecurityConfig;

return static function (SecurityConfig $security): void {
    $security->enableAuthenticatorManager(true);

    $security->passwordHasher(PasswordAuthenticatedUserInterface::class)->algorithm('auto');

    $security->provider('security_provider')->id(UserProvider::class);

    $security->firewall('dev')
        ->pattern('^/(_(profiler|wdt)|css|images|js)/')
        ->security(false);

    $security->firewall('main')
        ->lazy(true)
        ->provider('security_provider');
};
