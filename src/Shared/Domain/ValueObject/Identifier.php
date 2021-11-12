<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Stringable;
use Symfony\Component\Uid\Uuid;

final class Identifier implements Stringable
{
    public function __construct(private Uuid $uuid)
    {
    }

    public function __toString(): string
    {
        return (string) $this->uuid;
    }

    public static function fromString(string $uuid): Identifier
    {
        return new self(Uuid::fromString($uuid));
    }
}
