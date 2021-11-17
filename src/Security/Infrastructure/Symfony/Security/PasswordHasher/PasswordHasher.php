<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Symfony\Security\PasswordHasher;

use App\Security\Domain\Contract\Security\PasswordHasher\PasswordHasherInterface;
use App\Security\Domain\ValueObject\Password\HashedPassword;
use App\Security\Domain\ValueObject\Password\PlainPassword;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;

final class PasswordHasher implements PasswordHasherInterface
{
    public function __construct(private NativePasswordHasher $decorated)
    {
    }

    public function hashPassword(PlainPassword $plainPassword): HashedPassword
    {
        return HashedPassword::createFromString($this->decorated->hash((string) $plainPassword));
    }

    public function verifyPassword(HashedPassword $hashedPassword, PlainPassword $plainPassword): bool
    {
        return $this->decorated->verify((string) $hashedPassword, (string) $plainPassword);
    }
}
