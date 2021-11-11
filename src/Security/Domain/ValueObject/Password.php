<?php

declare(strict_types=1);

namespace App\Security\Domain\ValueObject;

use Stringable;

final class Password implements Stringable
{
    public function __construct(private string $hashedPassword)
    {
    }

    public function __toString(): string
    {
        return $this->hashedPassword;
    }
}
