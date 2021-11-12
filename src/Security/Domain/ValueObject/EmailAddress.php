<?php

declare(strict_types=1);

namespace App\Security\Domain\ValueObject;

use Stringable;

final class EmailAddress implements Stringable
{
    public function __construct(private string $email)
    {
    }

    public function __toString(): string
    {
        return $this->email;
    }
}
