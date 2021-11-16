<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Type;

use App\Shared\Domain\ValueObject\Token\UuidToken;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class UuidTokenType extends Type
{
    public const NAME = 'uuid_token';

    /**
     * @param array<array-key, mixed> $column
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'varchar(36)';
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param ?UuidToken $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        return (string) $value;
    }

    /**
     * @param ?string $value
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?UuidToken
    {
        if (null === $value) {
            return null;
        }

        return UuidToken::createFromString($value);
    }
}
