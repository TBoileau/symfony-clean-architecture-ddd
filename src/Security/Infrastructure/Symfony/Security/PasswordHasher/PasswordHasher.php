<?php

/**
 * Copyright (C) Thomas Boileau - All Rights Reserved.
 *
 * This source code is protected under international copyright law.
 * All rights reserved and protected by the copyright holders.
 * This file is confidential and only available to authorized individuals with the
 * permission of the copyright holders. If you encounter this file and do not have
 * permission, please contact the copyright holders and delete this file.
 */

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
