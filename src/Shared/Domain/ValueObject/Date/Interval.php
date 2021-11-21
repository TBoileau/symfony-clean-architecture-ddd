<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject\Date;

use App\Shared\Domain\Exception\InvalidArgumentException;
use DateInterval;
use Exception;

final class Interval
{
    private function __construct(public string $interval)
    {
    }

    public function __toString(): string
    {
        return $this->interval;
    }

    public static function createFromString(string $interval): Interval
    {
        try {
            new DateInterval($interval);
        } catch (Exception) {
            throw new InvalidArgumentException('Interval invalid.');
        }

        return new Interval($interval);
    }

    public function toDateInterval(): DateInterval
    {
        return new DateInterval($this->interval);
    }
}
