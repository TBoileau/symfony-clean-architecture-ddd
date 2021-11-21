<?php

declare(strict_types=1);

namespace App\Security\Domain\Tests\Fixtures\Infrastructure\Security;

use App\Security\Domain\Contract\Security\PasswordHasher\PasswordHasherInterface;
use App\Security\Domain\ValueObject\Password\HashedPassword;
use App\Security\Domain\ValueObject\Password\PlainPassword;

final class PasswordHasher implements PasswordHasherInterface
{
    public function hashPassword(PlainPassword $plainPassword): HashedPassword
    {
        return HashedPassword::createFromString(password_hash((string) $plainPassword, PASSWORD_BCRYPT));
    }

    public function verifyPassword(HashedPassword $hashedPassword, PlainPassword $plainPassword): bool
    {
        return password_verify((string) $plainPassword, (string) $hashedPassword);
    }
}
