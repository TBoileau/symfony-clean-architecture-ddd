<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject\Uuid;

use Stringable;
use Symfony\Component\Uid\Uuid;

abstract class AbstractUuid implements Stringable
{
    protected function __construct(private Uuid $uuid)
    {
    }

    public function __toString(): string
    {
        return (string) $this->uuid;
    }

    abstract public static function create(): AbstractUuid;

    abstract public static function createFromString(string $uuid): AbstractUuid;

    abstract public static function createFromUuid(Uuid $uuid): AbstractUuid;

    public function uuid(): Uuid
    {
        return $this->uuid;
    }
}
