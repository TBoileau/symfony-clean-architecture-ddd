<?php

declare(strict_types=1);

namespace App\Security\Domain\Contract\Security\PasswordHasher;

use App\Security\Domain\ValueObject\Password\HashedPassword;
use App\Security\Domain\ValueObject\Password\PlainPassword;

interface PasswordHasherInterface
{
    public function hashPassword(PlainPassword $plainPassword): HashedPassword;

    public function verifyPassword(HashedPassword $hashedPassword, PlainPassword $plainPassword): bool;
}
