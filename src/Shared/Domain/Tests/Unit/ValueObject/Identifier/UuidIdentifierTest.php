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

namespace App\Shared\Domain\Tests\Unit\ValueObject\Identifier;

use App\Shared\Domain\Exception\InvalidArgumentException;
use App\Shared\Domain\ValueObject\Identifier\UuidIdentifier;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class UuidIdentifierTest extends TestCase
{
    public function testIfFactoriesCreateIdentifier(): void
    {
        $identifier = UuidIdentifier::create();
        $this->assertTrue(Uuid::isValid((string) $identifier));
        $this->assertInstanceOf(Uuid::class, $identifier->uuid());

        $identifier = UuidIdentifier::createFromString((string) Uuid::v4());
        $this->assertTrue(Uuid::isValid((string) $identifier));
        $this->assertInstanceOf(Uuid::class, $identifier->uuid());

        $identifier = UuidIdentifier::createFromUuid(Uuid::v4());
        $this->assertTrue(Uuid::isValid((string) $identifier));
        $this->assertInstanceOf(Uuid::class, $identifier->uuid());
    }

    public function testIfUuidIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        UuidIdentifier::createFromString('fail');
    }
}
