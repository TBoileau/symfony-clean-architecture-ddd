<?php

declare(strict_types=1);

use App\Security\Infrastructure\Doctrine\Type\HashedPasswordType;
use App\Shared\Infrastructure\Doctrine\Type\DateTimeType;
use App\Shared\Infrastructure\Doctrine\Type\EmailAddressType;
use App\Shared\Infrastructure\Doctrine\Type\UuidIdentifierType;
use App\Shared\Infrastructure\Doctrine\Type\UuidTokenType;

$metadata->mapField([
    'id' => true,
    'fieldName' => 'identifier',
    'type' => UuidIdentifierType::NAME,
]);

$metadata->mapField([
    'fieldName' => 'email',
    'type' => EmailAddressType::NAME,
]);

$metadata->mapField([
    'fieldName' => 'hashedPassword',
    'type' => HashedPasswordType::NAME,
]);

$metadata->mapField([
    'fieldName' => 'expiredAt',
    'type' => DateTimeType::NAME,
    'nullable' => true,
]);

$metadata->mapField([
    'fieldName' => 'suspendedAt',
    'type' => DateTimeType::NAME,
    'nullable' => true,
]);

$metadata->mapField([
    'fieldName' => 'forgottenPasswordRequestedAt',
    'type' => DateTimeType::NAME,
    'nullable' => true,
]);

$metadata->mapField([
    'fieldName' => 'forgottenPasswordToken',
    'type' => UuidTokenType::NAME,
    'nullable' => true,
]);
