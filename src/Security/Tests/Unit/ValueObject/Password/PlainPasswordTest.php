<?php

declare(strict_types=1);

namespace App\Security\Tests\Unit\ValueObject\Password;

use App\Security\Domain\ValueObject\Password\PlainPassword;
use PHPUnit\Framework\TestCase;

final class PlainPasswordTest extends TestCase
{
    public function testIfFactoryCreateHashedPassword(): void
    {
        $plainPassword = PlainPassword::createFromString('test');
        $this->assertEquals('test', (string) $plainPassword);
    }
}
