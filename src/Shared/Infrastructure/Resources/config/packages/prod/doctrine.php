<?php

declare(strict_types=1);

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;
use Symfony\Config\DoctrineConfig;

return static function (DoctrineConfig $doctrine): void {
    $doctrine->dbal()
        ->connection('default')
            ->url(env('DATABASE_URL'));

    $doctrine->orm()
        ->entityManager('default')
            ->namingStrategy('doctrine.orm.naming_strategy.underscore_number_aware');
};
