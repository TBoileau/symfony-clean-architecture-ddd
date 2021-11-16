<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject\Uuid;

use App\Shared\Domain\Exception\InvalidArgumentException;
use Stringable;
use Symfony\Component\Uid\Uuid;

abstract class AbstractUuid implements Stringable
{
    private function __construct(private Uuid $uuid)
    {
    }

    public function __toString(): string
    {
        return (string) $this->uuid;
    }

    public static function create(): AbstractUuid
    {
        return new static(Uuid::v4());
    }

    public static function createFromString(string $uuid): AbstractUuid
    {
        if (!Uuid::isValid($uuid)) {
            throw new InvalidArgumentException(sprintf('%s is not an Uuid valid.', $uuid));
        }

        return self::createFromUuid(Uuid::fromString($uuid));
    }

    public static function createFromUuid(Uuid $uuid): AbstractUuid
    {
        return new static($uuid);
    }

    public function uuid(): Uuid
    {
        return $this->uuid;
    }
}
