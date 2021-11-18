<?php

/**
 * Copyright (C) Thomas Boileau - All Rights Reserved.
 *
 * This source code is protected under international copyright law.
 * All rights reserved and protected by the copyright holders.
 * This file is confidential and only available to authorized individuals with the
 * permission of the copyright holders. If you encounter this file and do not have
 * permission, please contact the copyright holders and delete this file.
 */

declare(strict_types=1);

use App\Security\Infrastructure\Symfony\Security\PasswordHasher\PasswordHasher;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;

return function (ContainerConfigurator $container) {
    $container = $container->services()->defaults()
        ->bind('string $emailNoReply', param('mailer.no_reply'))
        ->public()
        ->autoconfigure()
        ->autowire();

    $container
        ->load('App\\Security\\', __DIR__.'/../../../../')
        ->exclude([
            __DIR__.'/../',
            __DIR__.'/../../../../Domain/ValueObject',
            __DIR__.'/../../../../Domain/Entity',
            __DIR__.'/../../../../Domain/Tests',
            __DIR__.'/../../../../Domain/UseCase/**/*Output.php',
            __DIR__.'/../../../../UserInterface/ViewModel',
            __DIR__.'/../../../../UserInterface/Input',
            __DIR__.'/../../../../UserInterface/Controller',
            __DIR__.'/../../../../Infrastructure/Symfony/Security/User/UserProxy.php',
            __DIR__.'/../../../../Infrastructure/Symfony/Security/Authenticator/Passport/PasswordCredentials.php',
            __DIR__.'/../../../../Infrastructure/Tests',
        ]);

    $container
        ->load('App\\Security\\UserInterface\\Controller\\', __DIR__.'/../../../../UserInterface/Controller')
        ->tag('controller.service_arguments');

    $container->set(NativePasswordHasher::class);

    $container->set(PasswordHasher::class)
        ->decorate(NativePasswordHasher::class)
        ->args([service('.inner')]);
};
