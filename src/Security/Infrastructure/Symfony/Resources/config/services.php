<?php

declare(strict_types=1);

use App\Security\Infrastructure\Symfony\PasswordHasher\PasswordHasher;
use App\Security\UserInterface\Responder\LoginResponder;
use App\Shared\UserInterface\Responder\TwigResponder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;

return function (ContainerConfigurator $container) {
    $container = $container->services()->defaults()
        ->public()
        ->autoconfigure()
        ->autowire();

    $container
        ->load('App\\Security\\', __DIR__.'/../../../../')
        ->exclude([
            __DIR__.'/../',
            __DIR__.'/../../../../Domain/ValueObject',
            __DIR__.'/../../../../Domain/Entity',
            __DIR__.'/../../../../UserInterface/ViewModel',
            __DIR__.'/../../../../UserInterface/Controller',
            __DIR__.'/../../../../Infrastructure/Symfony/Security/User/UserProxy.php',
            __DIR__.'/../../../../Infrastructure/Symfony/Security/Authenticator/Passport/PasswordCredentials.php',
        ]);

    $container
        ->load('App\\Security\\UserInterface\\Controller\\', __DIR__.'/../../../../UserInterface/Controller')
        ->tag('controller.service_arguments');

    $container->set(LoginResponder::class)
        ->decorate(TwigResponder::class);

    $container->set(NativePasswordHasher::class);

    $container->set(PasswordHasher::class)
        ->decorate(NativePasswordHasher::class)
        ->args([service('.inner')]);
};
