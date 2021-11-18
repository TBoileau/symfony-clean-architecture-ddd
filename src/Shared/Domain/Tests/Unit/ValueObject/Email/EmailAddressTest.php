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

namespace App\Shared\Domain\Tests\Unit\ValueObject\Email;

use App\Shared\Domain\Exception\InvalidArgumentException;
use App\Shared\Domain\ValueObject\Email\EmailAddress;
use PHPUnit\Framework\TestCase;

final class EmailAddressTest extends TestCase
{
    public function testIfFactoryCreateEmailAddress(): void
    {
        $emailAddress = EmailAddress::createFromString('user+1@email.com');
        $this->assertEquals('user+1@email.com', (string) $emailAddress);
        $this->assertTrue($emailAddress->equalTo(EmailAddress::createFromString('user+1@email.com')));
    }

    public function testIfEmailAddressIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        EmailAddress::createFromString('fail');
    }
}
