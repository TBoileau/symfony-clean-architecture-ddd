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

namespace App\Security\Domain\ValueObject\Password;

use App\Security\Domain\Contract\Security\PasswordHasher\PasswordHasherInterface;
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
