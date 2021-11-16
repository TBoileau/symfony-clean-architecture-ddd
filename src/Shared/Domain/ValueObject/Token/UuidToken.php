<?php

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
}
