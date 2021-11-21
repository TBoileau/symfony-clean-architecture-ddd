<?php

declare(strict_types=1);

namespace App\Shared\Domain\Tests\Unit\ValueObject\Date;

use App\Shared\Domain\Exception\InvalidArgumentException;
use App\Shared\Domain\ValueObject\Date\Date;
use App\Shared\Domain\ValueObject\Date\Interval;
use DateTime;
use DateTimeInterface;
use Generator;
use PHPUnit\Framework\TestCase;

final class DateTest extends TestCase
{
    public function testIfFactoriesCreateDates(): void
    {
        $this->assertDate(Date::create(2021, 12, 15));
        $this->assertDate(Date::createFromDateTime(new DateTime('2021-12-15')));
        $this->assertDate(Date::createFromString('2021-12-15'));
    }

    /**
     * @dataProvider provideInvalidDate
     */
    public function testIfDateIsInvalid(int $year, int $month, int $day): void
    {
        $this->expectException(InvalidArgumentException::class);
        Date::create($year, $month, $day);
    }

    /**
     * @return Generator<string, array<array-key, int>>
     */
    public function provideInvalidDate(): Generator
    {
        yield 'invalid month' => [2021, 13, 1];
        yield 'invalid day' => [2021, 12, 32];
    }

    private function assertDate(Date $date): void
    {
        $this->assertEquals(2021, $date->year());
        $this->assertEquals(12, $date->month());
        $this->assertEquals(15, $date->day());
        $this->assertEquals('2021-12-15', (string) $date);
        $this->assertInstanceOf(DateTimeInterface::class, $date->toDateTime());
        $this->assertTrue($date->isLaterThan(Date::createFromString('2020-01-01')));
        $this->assertTrue($date->isEarlierThan(Date::createFromString('2022-01-01')));
        $newDate = $date->add(Interval::createFromString('P1D'));
        $this->assertEquals('2021-12-16', (string) $newDate);
        $newDate = $date->sub(Interval::createFromString('P1D'));
        $this->assertEquals('2021-12-14', (string) $newDate);
    }
}
