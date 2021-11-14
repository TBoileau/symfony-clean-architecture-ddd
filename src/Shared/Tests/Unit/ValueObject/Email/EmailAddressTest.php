<?php

declare(strict_types=1);

namespace App\Shared\Tests\Unit\ValueObject\Email;

use App\Shared\Domain\Exception\InvalidArgumentException;
use App\Shared\Domain\ValueObject\Email\EmailAddress;
use PHPUnit\Framework\TestCase;

final class EmailAddressTest extends TestCase
{
    public function testIfFactoryCreateEmailAddress(): void
    {
        $emailAddress = EmailAddress::createFromString('user+1@email.com');
        $this->assertEquals('user+1@email.com', (string) $emailAddress);
    }

    public function testIfEmailAddressIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        EmailAddress::createFromString('fail');
    }
}
