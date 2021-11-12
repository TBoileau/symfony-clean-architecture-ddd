<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container) {
    $container = $container->services()->defaults()
        ->public()
        ->autoconfigure()
        ->autowire();

    $container
        ->load('App\\', __DIR__.'/../../../../')
        ->exclude([
            __DIR__.'/../../../../**/Resources',
            __DIR__.'/../../../../**/ValueObject',
            __DIR__.'/../../../../**/Entity',
            __DIR__.'/../../../../**/ViewModel',
            __DIR__.'/../../../../**/Controller',
            __DIR__.'/../../../../**/User.php',
        ]);
};
