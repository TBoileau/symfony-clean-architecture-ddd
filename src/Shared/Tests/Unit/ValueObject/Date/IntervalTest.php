<?php

declare(strict_types=1);

namespace App\Shared\Tests\Unit\ValueObject\Date;

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
