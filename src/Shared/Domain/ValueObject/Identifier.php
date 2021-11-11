<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Symfony\Component\Uid\Uuid;

final class Identifier
{
    public function __construct(private Uuid $uuid)
    {
    }
}
