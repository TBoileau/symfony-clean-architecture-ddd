<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject\Date;

interface DateTimeInterface
{
    public static function createFromDateTime(\DateTimeInterface $dateTime): DateTimeInterface;

    public static function createFromString(string $dateTime): DateTimeInterface;

    public static function now(): DateTimeInterface;

    public function toDateTime(): \DateTimeInterface;

    public function isEarlierThan(DateTimeInterface $date): bool;

    public function isLaterThan(DateTimeInterface $date): bool;
}
