<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject\Date;

use DateTimeImmutable;

final class DateTime extends AbstractDateTime implements DateTimeInterface
{
    private function __construct(private Date $date, private Time $time)
    {
    }

    public function __toString(): string
    {
        return sprintf('%s %s', $this->date, $this->time);
    }

    public static function create(
        int $year,
        int $month,
        int $day,
        int $hours,
        int $minutes,
        int $seconds
    ): DateTime {
        return new DateTime(Date::create($year, $month, $day), Time::create($hours, $minutes, $seconds));
    }

    public static function createFromDateAndTime(Date $date, Time $time): DateTime
    {
        return new DateTime($date, $time);
    }

    public static function createFromDateTime(\DateTimeInterface $dateTime): DateTime
    {
        return self::createFromDateAndTime(Date::createFromDateTime($dateTime), Time::createFromDateTime($dateTime));
    }

    public static function createFromString(string $dateTime): DateTime
    {
        return self::createFromDateAndTime(Date::createFromString($dateTime), Time::createFromString($dateTime));
    }

    /**
     * @codeCoverageIgnore
     */
    public static function now(): DateTime
    {
        return self::createFromDateTime(new DateTimeImmutable());
    }

    public function add(Interval $interval): DateTime
    {
        /** @var DateTimeImmutable $dateTime */
        $dateTime = $this->toDateTime();

        return self::createFromDateTime($dateTime->add($interval->toDateInterval()));
    }

    public function toDateTime(): \DateTimeInterface
    {
        return new DateTimeImmutable((string) $this);
    }

    public function date(): Date
    {
        return $this->date;
    }

    public function time(): Time
    {
        return $this->time;
    }
}
