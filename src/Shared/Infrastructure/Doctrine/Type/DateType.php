<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Type;

use App\Shared\Domain\ValueObject\Date\Date;
use DateTimeInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateType as DoctrineDateType;

final class DateType extends DoctrineDateType
{
    public const NAME = 'date';

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param ?Date $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        /* @phpstan-ignore-next-line */
        return parent::convertToDatabaseValue($value->toDateTime(), $platform);
    }

    /**
     * @param string $value
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Date
    {
        if ($value === null) {
            return null;
        }

        /** @var DateTimeInterface $dateTime */
        $dateTime = parent::convertToPHPValue($value, $platform);

        return Date::createFromDateTime($dateTime);
    }
}
