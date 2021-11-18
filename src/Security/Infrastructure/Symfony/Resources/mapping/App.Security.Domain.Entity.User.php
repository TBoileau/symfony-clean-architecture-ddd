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
