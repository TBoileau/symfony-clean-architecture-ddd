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

namespace App\Security\Infrastructure\Symfony\Security\Authenticator\Passport;

use App\Security\Domain\Contract\Security\PasswordHasher\PasswordHasherInterface;
use App\Security\Domain\ValueObject\Password\HashedPassword;
use App\Security\Domain\ValueObject\Password\PlainPassword;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CredentialsInterface;

final class PasswordCredentials implements CredentialsInterface
{
    private bool $resolved = false;

    public function __construct(private PlainPassword $plainPassword)
    {
    }

    public function verify(PasswordHasherInterface $passwordHasher, HashedPassword $hashedPassword): void
    {
        if (!$hashedPassword->verify($passwordHasher, $this->plainPassword)) {
            throw new BadCredentialsException('Invalid credentials.');
        }

        $this->resolved = true;
    }

    public function isResolved(): bool
    {
        return $this->resolved;
    }
}
