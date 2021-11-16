<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject\Date;

use App\Shared\Domain\Exception\InvalidArgumentException;
use DateTimeImmutable;

final class Date extends AbstractDateTime implements DateTimeInterface
{
    private function __construct(private int $year, private int $month, private int $day)
    {
        if ($this->month < 1 || $this->month > 12) {
            throw new InvalidArgumentException('Month should be between 1 and 12');
        }

        if ($this->day < 1 || $this->day > 31) {
            throw new InvalidArgumentException('Day should be between 1 and 31');
        }
    }

    public function __toString(): string
    {
        return sprintf('%04d-%02d-%02d', $this->year, $this->month, $this->day);
    }

    public static function create(int $year, int $month, int $day): Date
    {
        return new Date($year, $month, $day);
    }

    public static function createFromString(string $date): Date
    {
        return self::createFromDateTime(new DateTimeImmutable($date));
    }

    public static function createFromDateTime(\DateTimeInterface $dateTime): Date
    {
        return self::create(
            intval($dateTime->format('Y')),
            intval($dateTime->format('m')),
            intval($dateTime->format('d'))
        );
    }

    /**
     * @codeCoverageIgnore
     */
    public static function now(): Date
    {
        return self::createFromDateTime(new DateTimeImmutable());
    }

    public function add(Interval $interval): Date
    {
        /** @var DateTimeImmutable $dateTime */
        $dateTime = $this->toDateTime();

        return self::createFromDateTime($dateTime->add($interval->toDateInterval()));
    }

    public function toDateTime(): \DateTimeInterface
    {
        return new DateTimeImmutable((string) $this);
    }

    public function year(): int
    {
        return $this->year;
    }

    public function month(): int
    {
        return $this->month;
    }

    public function day(): int
    {
        return $this->day;
    }
}
