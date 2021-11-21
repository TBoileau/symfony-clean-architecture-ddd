<?php

declare(strict_types=1);

namespace App\Security\Domain\Tests\Unit\Entity;

use App\Security\Domain\Entity\User;
use App\Security\Domain\Tests\Fixtures\Infrastructure\Security\PasswordHasher;
use App\Security\Domain\ValueObject\Password\HashedPassword;
use App\Security\Domain\ValueObject\Password\PlainPassword;
use App\Shared\Domain\Exception\InvalidArgumentException;
use App\Shared\Domain\ValueObject\Date\DateTime;
use App\Shared\Domain\ValueObject\Email\EmailAddress;
use App\Shared\Domain\ValueObject\Identifier\UuidIdentifier;
use App\Shared\Domain\ValueObject\Token\UuidToken;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    public function testIfUserSerializationIsSuccessful(): void
    {
        $user = User::create(
            identifier: UuidIdentifier::createFromString('34fd9095-de5b-45d7-b1ff-7a13cdb6066d'),
            email: EmailAddress::createFromString('user@email.com'),
            hashedPassword: HashedPassword::createFromString('test'),
            expiredAt: DateTime::createFromString('2022-01-01 00:00:00'),
            suspendedAt: DateTime::createFromString('2022-01-01 00:00:00'),
            forgottenPasswordToken: UuidToken::createFromString('34fd9095-de5b-45d7-b1ff-7a13cdb6066d'),
            forgottenPasswordRequestedAt: DateTime::createFromString('2022-01-01 00:00:00'),
        );
        $this->assertEquals('34fd9095-de5b-45d7-b1ff-7a13cdb6066d', (string) $user->identifier);
        $this->assertEquals('34fd9095-de5b-45d7-b1ff-7a13cdb6066d', (string) $user->forgottenPasswordToken);
        $this->assertEquals('user@email.com', (string) $user->email);
        $this->assertEquals('test', (string) $user->hashedPassword);
        $this->assertEquals('2022-01-01 00:00:00', (string) $user->expiredAt);
        $this->assertEquals('2022-01-01 00:00:00', (string) $user->suspendedAt);
        $this->assertEquals('2022-01-01 00:00:00', (string) $user->forgottenPasswordRequestedAt);
        $this->assertFalse($user->isExpired());
        $this->assertFalse($user->isSupended());

        $user->forgottenPasswordRequestedAt = DateTime::now();
        $this->assertTrue($user->canResetPassword());

        $user->forgottenPasswordRequestedAt = DateTime::createFromDateTime(new DateTimeImmutable('2 days ago'));
        $this->assertFalse($user->canResetPassword());

        $user->requestForAForgottenPassword();
        $this->assertTrue($user->canResetPassword());

        $user->plainPassword = PlainPassword::createFromString('new_password');
        $user->resetPassword(new PasswordHasher());
        $this->assertFalse($user->canResetPassword());
        $this->assertNull($user->forgottenPasswordToken);
        $this->assertNull($user->forgottenPasswordRequestedAt);

        $this->expectException(InvalidArgumentException::class);
        $user->resetPassword(new PasswordHasher());
    }
}
