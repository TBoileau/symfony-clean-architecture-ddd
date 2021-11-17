<?php

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
