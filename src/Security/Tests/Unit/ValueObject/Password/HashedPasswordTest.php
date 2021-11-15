<?php

declare(strict_types=1);

namespace App\Security\Tests\Unit\ValueObject\Password;

use App\Security\Domain\PasswordHasher\PasswordHasherInterface;
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

        $this->assertTrue($hashedPassword->verify(new class() implements PasswordHasherInterface {
            public function verifyPassword(HashedPassword $hashedPassword, PlainPassword $plainPassword): bool
            {
                return (string) $hashedPassword === (string) $plainPassword;
            }
        }, $plainPassword));
    }
}
