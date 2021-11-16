<?php

declare(strict_types=1);

use App\Shared\Infrastructure\Doctrine\Type\DateTimeType;
use App\Shared\Infrastructure\Doctrine\Type\DateType;
use App\Shared\Infrastructure\Doctrine\Type\EmailAddressType;
use App\Shared\Infrastructure\Doctrine\Type\TimeType;
use App\Shared\Infrastructure\Doctrine\Type\UuidIdentifierType;
use App\Shared\Infrastructure\Doctrine\Type\UuidTokenType;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;
use Symfony\Config\DoctrineConfig;

return static function (DoctrineConfig $doctrine): void {
    $doctrine->dbal()
        ->connection('default')
            ->url(env('DATABASE_URL'));

    $doctrine->orm()
        ->entityManager('default')
            ->namingStrategy('doctrine.orm.naming_strategy.underscore_number_aware');

    $doctrine->dbal()->type(UuidIdentifierType::NAME)->class(UuidIdentifierType::class);
    $doctrine->dbal()->type(UuidTokenType::NAME)->class(UuidTokenType::class);
    $doctrine->dbal()->type(DateType::NAME)->class(DateType::class);
    $doctrine->dbal()->type(DateTimeType::NAME)->class(DateTimeType::class);
    $doctrine->dbal()->type(TimeType::NAME)->class(TimeType::class);
    $doctrine->dbal()->type(EmailAddressType::NAME)->class(EmailAddressType::class);
};
