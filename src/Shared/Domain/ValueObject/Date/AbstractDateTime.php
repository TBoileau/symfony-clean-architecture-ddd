<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject\Date;

abstract class AbstractDateTime implements DateTimeInterface
{
    public function isEarlierThan(DateTimeInterface $date): bool
    {
        return $this->toDateTime() < $date->toDateTime();
    }

    public function isLaterThan(DateTimeInterface $date): bool
    {
        return $this->toDateTime() > $date->toDateTime();
    }
}
