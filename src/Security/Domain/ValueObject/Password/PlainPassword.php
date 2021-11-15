<?php

declare(strict_types=1);

namespace App\Security\Domain\ValueObject\Password;

use App\Security\Domain\PasswordHasher\PasswordHasherInterface;
use Stringable;

final class PlainPassword implements Stringable
{
    private function __construct(public string $plainPassword)
    {
    }

    public function __toString(): string
    {
        return $this->plainPassword;
    }

    public static function createFromString(string $plainPassword): PlainPassword
    {
        return new PlainPassword($plainPassword);
    }

    public function hash(PasswordHasherInterface $passwordHasher): HashedPassword
    {
        return $passwordHasher->hashPassword($this);
    }
}
