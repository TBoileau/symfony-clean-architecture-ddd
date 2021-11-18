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

namespace App\Shared\Domain\Tests\Unit\ValueObject\Date;

use App\Shared\Domain\Exception\InvalidArgumentException;
use App\Shared\Domain\ValueObject\Date\Interval;
use DateInterval;
use PHPUnit\Framework\TestCase;

final class IntervalTest extends TestCase
{
    public function testIfFactoryCreateInterval(): void
    {
        $interval = Interval::createFromString('P1D');
        $this->assertInstanceOf(DateInterval::class, $interval->toDateInterval());
        $this->assertEquals('P1D', (string) $interval);
    }

    public function testIfIntervalIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Interval::createFromString('FAIL');
    }
}
