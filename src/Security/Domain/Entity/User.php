<?php

declare(strict_types=1);

namespace App\Security\Domain\Entity;

use App\Security\Domain\ValueObject\Password\HashedPassword;
use App\Shared\Domain\ValueObject\Email\EmailAddress;
use App\Shared\Domain\ValueObject\Identifier\UuidIdentifier;
use Serializable;

final class User implements Serializable
{
    public function __construct(
        public UuidIdentifier $identifier,
        public EmailAddress $email,
        public HashedPassword $password
    ) {
    }

    public function serialize(): string
    {
        return serialize([
            (string) $this->identifier,
            (string) $this->email,
            (string) $this->password,
        ]);
    }

    /**
     * @param string $data
     */
    public function unserialize(mixed $data): void
    {
        /** @var array<array-key, string> $deserializedData */
        $deserializedData = unserialize($data, ['allowed_classes' => false]);

        /**
         * @var string $identifier
         * @var string $email,
         * @var string $password
         */
        [
            $identifier,
            $email,
            $password,
        ] = $deserializedData;

        $this->identifier = UuidIdentifier::createFromString($identifier);
        $this->email = EmailAddress::createFromString($email);
        $this->password = HashedPassword::createFromString($password);
    }
}
