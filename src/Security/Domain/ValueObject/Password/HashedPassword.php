<?php

declare(strict_types=1);

namespace App\Security\Domain\ValueObject\Password;

use App\Security\Domain\PasswordHasher\PasswordHasherInterface;
use Stringable;

class HashedPassword implements Stringable
{
    private function __construct(private string $hashedPassword)
    {
    }

    public function __toString(): string
    {
        return $this->hashedPassword;
    }

    public static function createFromString(string $hashedPassword): HashedPassword
    {
        return new HashedPassword($hashedPassword);
    }

    public function verify(PasswordHasherInterface $passwordHasher, PlainPassword $plainPassword): bool
    {
        return $passwordHasher->verifyPassword($this, $plainPassword);
    }
}
