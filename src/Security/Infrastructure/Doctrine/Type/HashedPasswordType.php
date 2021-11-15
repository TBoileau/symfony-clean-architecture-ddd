<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Doctrine\Type;

use App\Security\Domain\ValueObject\Password\HashedPassword;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class HashedPasswordType extends StringType
{
    public const NAME = 'hashed_password';

    /**
     * @param array<array-key, mixed> $column
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'varchar(255)';
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param HashedPassword $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return (string) $value;
    }

    /**
     * @param string $value
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): HashedPassword
    {
        return HashedPassword::createFromString($value);
    }
}
