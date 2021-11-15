<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Type;

use App\Shared\Domain\ValueObject\Date\Time;
use DateTimeInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\TimeType as DoctrineTimeType;

final class TimeType extends DoctrineTimeType
{
    public const NAME = 'time';

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param Time $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        /* @phpstan-ignore-next-line */
        return parent::convertToDatabaseValue($value->toDateTime(), $platform);
    }

    /**
     * @param string $value
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): Time
    {
        /** @var DateTimeInterface $dateTime */
        $dateTime = parent::convertToPHPValue($value, $platform);

        return Time::createFromDateTime($dateTime);
    }
}
