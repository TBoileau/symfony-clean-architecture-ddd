<?php

declare(strict_types=1);

namespace App\Security\Domain\PasswordHasher;

use App\Security\Domain\ValueObject\Password\HashedPassword;
use App\Security\Domain\ValueObject\Password\PlainPassword;

interface PasswordHasherInterface
{
    public function verifyPassword(HashedPassword $hashedPassword, PlainPassword $plainPassword): bool;
}
