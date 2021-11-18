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

namespace App\Shared\Domain\ValueObject\Token;

use App\Shared\Domain\Exception\InvalidArgumentException;
use App\Shared\Domain\ValueObject\Uuid\AbstractUuid;
use Symfony\Component\Uid\Uuid;

class UuidToken extends AbstractUuid
{
    public static function create(): UuidToken
    {
        return new UuidToken(Uuid::v4());
    }

    public static function createFromString(string $uuid): UuidToken
    {
        if (!Uuid::isValid($uuid)) {
            throw new InvalidArgumentException(sprintf('%s is not an Uuid valid.', $uuid));
        }

        return self::createFromUuid(Uuid::fromString($uuid));
    }

    public static function createFromUuid(Uuid $uuid): UuidToken
    {
        return new UuidToken($uuid);
    }

    public function equalTo(UuidToken $token): bool
    {
        return (string) $token === (string) $this;
    }
}
