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

namespace App\Security\Domain\Tests\Unit\ValueObject\Password;

use App\Security\Domain\Contract\Security\PasswordHasher\PasswordHasherInterface;
use App\Security\Domain\ValueObject\Password\HashedPassword;
use App\Security\Domain\ValueObject\Password\PlainPassword;
use PHPUnit\Framework\TestCase;

final class HashedPasswordTest extends TestCase
{
    public function testIfFactoryCreateHashedPassword(): void
    {
        $hashedPassword = HashedPassword::createFromString('test');
        $this->assertEquals('test', (string) $hashedPassword);

        $plainPassword = PlainPassword::createFromString('test');

        $passwordHasher = $this->createMock(PasswordHasherInterface::class);
        $passwordHasher->method('verifyPassword')->willReturn(true);

        $this->assertTrue($hashedPassword->verify($passwordHasher, $plainPassword));
    }
}
