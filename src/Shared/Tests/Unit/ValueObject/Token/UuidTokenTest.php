<?php

declare(strict_types=1);

namespace App\Shared\Tests\Unit\ValueObject\Token;

use App\Shared\Domain\Exception\InvalidArgumentException;
use App\Shared\Domain\ValueObject\Token\UuidToken;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class UuidTokenTest extends TestCase
{
    public function testIfFactoriesCreateToken(): void
    {
        $identifier = UuidToken::create();
        $this->assertTrue(Uuid::isValid((string) $identifier));
        $this->assertInstanceOf(Uuid::class, $identifier->uuid());

        $identifier = UuidToken::createFromString((string) Uuid::v4());
        $this->assertTrue(Uuid::isValid((string) $identifier));
        $this->assertInstanceOf(Uuid::class, $identifier->uuid());

        $identifier = UuidToken::createFromUuid(Uuid::v4());
        $this->assertTrue(Uuid::isValid((string) $identifier));
        $this->assertInstanceOf(Uuid::class, $identifier->uuid());
    }

    public function testIfUuidIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        UuidToken::createFromString('fail');
    }
}
