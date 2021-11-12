<?php

declare(strict_types=1);

use App\Shared\Infrastructure\InMemory\Command\InMemoryDatabaseCreateCommand;
use App\Shared\Infrastructure\InMemory\Database;
use App\Shared\Infrastructure\InMemory\DataFixtures\FixtureLoader;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return function (ContainerConfigurator $container) {
    $container->parameters()->set('in_memory.database_path', env('IN_MEMORY_DATABASE_PATH')->resolve());

    $container = $container->services()->defaults()
        ->public()
        ->autoconfigure()
        ->autowire();

    $container
        ->load('App\\', __DIR__.'/../../../../')
        ->exclude([
            __DIR__.'/../../../../**/Resources',
            __DIR__.'/../../../../**/Mapping',
            __DIR__.'/../../../../**/Metadata',
            __DIR__.'/../../../../**/ValueObject',
            __DIR__.'/../../../../**/Entity',
            __DIR__.'/../../../../**/Common',
            __DIR__.'/../../../../**/ViewModel',
            __DIR__.'/../../../../**/Controller',
            __DIR__.'/../../../../**/User.php',
        ]);

    $container->set(FixtureLoader::class)->args([tagged_iterator('app.in_memory.fixtures')]);

    $container->set(InMemoryDatabaseCreateCommand::class)->args([param('in_memory.database_path')]);
    $container->set(DataBase::class)->arg('$inMemoryDatabasePath', param('in_memory.database_path'));
};
