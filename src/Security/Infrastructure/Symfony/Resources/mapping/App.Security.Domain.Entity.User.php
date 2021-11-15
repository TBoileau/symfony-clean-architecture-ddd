<?php

declare(strict_types=1);

use App\Security\Infrastructure\Doctrine\Type\HashedPasswordType;
use App\Shared\Infrastructure\Doctrine\Type\EmailAddressType;
use App\Shared\Infrastructure\Doctrine\Type\UuidIdentifierType;

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
