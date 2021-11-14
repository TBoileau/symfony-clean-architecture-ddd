<?php

declare(strict_types=1);

namespace App\Security\Tests\Unit\ValueObject\Password;

use App\Security\Domain\ValueObject\Password\HashedPassword;
use PHPUnit\Framework\TestCase;

final class HashedPasswordTest extends TestCase
{
    public function testIfFactoryCreateHashedPassword(): void
    {
        $hashedPassword = HashedPassword::createFromString('test');
        $this->assertEquals('test', (string) $hashedPassword);
    }
}
