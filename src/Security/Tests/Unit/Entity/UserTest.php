<?php

declare(strict_types=1);

namespace App\Security\Tests\Unit\Entity;

use App\Security\Domain\Entity\User;
use App\Security\Domain\ValueObject\Password\HashedPassword;
use App\Shared\Domain\ValueObject\Email\EmailAddress;
use App\Shared\Domain\ValueObject\Identifier\UuidIdentifier;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    public function testIfUserSerializationIsSuccessful(): void
    {
        $user = new User(
            UuidIdentifier::createFromString('34fd9095-de5b-45d7-b1ff-7a13cdb6066d'),
            EmailAddress::createFromString('user@email.com'),
            HashedPassword::createFromString('test')
        );
        $this->assertEquals('34fd9095-de5b-45d7-b1ff-7a13cdb6066d', (string) $user->identifier);
        $this->assertEquals('user@email.com', (string) $user->email);
        $this->assertEquals('test', (string) $user->hashedPassword);
    }
}
