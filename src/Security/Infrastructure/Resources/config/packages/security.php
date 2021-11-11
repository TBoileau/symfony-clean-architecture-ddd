<?php

declare(strict_types=1);

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Config\SecurityConfig;

return static function (SecurityConfig $security): void {
    $security->enableAuthenticatorManager(true);

    $security->passwordHasher(PasswordAuthenticatedUserInterface::class)->algorithm('auto');

    $security->provider('users_in_memory')->memory();

    $security->firewall('dev')
        ->pattern('^/(_(profiler|wdt)|css|images|js)/')
        ->security(false);

    $security->firewall('main')
        ->lazy(true)
        ->provider('users_in_memory');
};
