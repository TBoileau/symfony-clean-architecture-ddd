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
