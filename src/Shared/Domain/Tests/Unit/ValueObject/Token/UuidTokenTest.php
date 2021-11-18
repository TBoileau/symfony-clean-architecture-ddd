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

namespace App\Shared\Domain\Tests\Unit\ValueObject\Token;

use App\Shared\Domain\Exception\InvalidArgumentException;
use App\Shared\Domain\ValueObject\Token\UuidToken;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class UuidTokenTest extends TestCase
{
    public function testIfFactoriesCreateToken(): void
    {
        $token = UuidToken::create();
        $this->assertTrue(Uuid::isValid((string) $token));
        $this->assertInstanceOf(Uuid::class, $token->uuid());

        $token = UuidToken::createFromString((string) Uuid::v4());
        $this->assertTrue(Uuid::isValid((string) $token));
        $this->assertInstanceOf(Uuid::class, $token->uuid());

        $uuid = Uuid::v4();

        $token = UuidToken::createFromUuid($uuid);
        $this->assertTrue(Uuid::isValid((string) $token));
        $this->assertInstanceOf(Uuid::class, $token->uuid());
        $this->assertTrue($token->equalTo(UuidToken::createFromUuid($uuid)));
    }

    public function testIfUuidIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        UuidToken::createFromString('fail');
    }
}
