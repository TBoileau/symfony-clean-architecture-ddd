<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Type;

use App\Shared\Domain\ValueObject\Date\DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeType as DoctrineDateTimeType;

final class DateTimeType extends DoctrineDateTimeType
{
    public const NAME = 'date_time';

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param DateTime $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        /** @phpstan-ignore-next-line */
        return parent::convertToDatabaseValue($value->toDateTime(), $platform);
    }

    /**
     * @param string $value
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): DateTime
    {
        /** @var DateTimeInterface $dateTime */
        $dateTime = parent::convertToPHPValue($value, $platform);

        return DateTime::createFromDateTime($dateTime);
    }
}
