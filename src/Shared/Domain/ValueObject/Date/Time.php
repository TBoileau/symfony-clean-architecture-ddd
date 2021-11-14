<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject\Date;

use App\Shared\Domain\Exception\InvalidArgumentException;
use DateTimeImmutable;
use DateTimeInterface;
use Stringable;

class Time implements Stringable
{
    private function __construct(private int $hours, private int $minutes, private int $seconds)
    {
        if ($this->hours < 0 || $this->hours > 23) {
            throw new InvalidArgumentException('Hours should be between 0 and 23');
        }

        if ($this->minutes < 0 || $this->minutes > 59) {
            throw new InvalidArgumentException('Minutes should be between 0 and 59');
        }

        if ($this->seconds < 0 || $this->seconds > 59) {
            throw new InvalidArgumentException('Seconds should be between 0 and 59');
        }
    }

    public function __toString(): string
    {
        return sprintf('%02d:%02d:%02d', $this->hours, $this->minutes, $this->seconds);
    }

    public static function createFromDateTime(DateTimeInterface $dateTime): Time
    {
        return self::create(
            intval($dateTime->format('H')),
            intval($dateTime->format('i')),
            intval($dateTime->format('s'))
        );
    }

    public static function createFromString(string $time): Time
    {
        return self::createFromDateTime(new DateTimeImmutable($time));
    }

    public static function create(int $hours, int $minutes, int $seconds): Time
    {
        return new Time($hours, $minutes, $seconds);
    }

    /**
     * @codeCoverageIgnore
     */
    public static function now(): Time
    {
        return self::createFromDateTime(new DateTimeImmutable());
    }

    public function toDateTime(): DateTimeInterface
    {
        return new DateTimeImmutable((string) $this);
    }

    public function hours(): int
    {
        return $this->hours;
    }

    public function minutes(): int
    {
        return $this->minutes;
    }

    public function seconds(): int
    {
        return $this->seconds;
    }
}
