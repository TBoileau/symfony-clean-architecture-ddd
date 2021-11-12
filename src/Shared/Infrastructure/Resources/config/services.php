<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container) {
    $container = $container->services()->defaults()
        ->public()
        ->autoconfigure()
        ->autowire();

    $container
        ->load('App\\', __DIR__.'/../../../../*')
        ->exclude([
            __DIR__.'/../../../../**/Infrastructure/Resources',
            __DIR__.'/../../../../**/Infrastructure/Model',
            __DIR__.'/../../../../**/Domain/ValueObject',
            __DIR__.'/../../../../**/Domain/Entity',
            __DIR__.'/../../../../**/UserInterface/ViewModel',
            __DIR__.'/../../../../**/UserInterface/Controller',
            __DIR__.'/../../../../**/User.php',
        ]);
};
