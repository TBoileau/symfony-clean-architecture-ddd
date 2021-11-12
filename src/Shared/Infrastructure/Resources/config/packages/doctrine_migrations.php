<?php

declare(strict_types=1);

use function Symfony\Component\DependencyInjection\Loader\Configurator\param;
use Symfony\Config\DoctrineMigrationsConfig;

return static function (DoctrineMigrationsConfig $doctrineMigration): void {
    $doctrineMigration
        ->migrationsPath(
            'DoctrineMigrations',
            sprintf('%s/migrations', param('kernel.project_dir'))
        )
        ->enableProfiler(param('kernel.debug'));
};
