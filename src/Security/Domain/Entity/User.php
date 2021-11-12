<?php

declare(strict_types=1);

namespace App\Security\Domain\Entity;

use App\Security\Domain\ValueObject\EmailAddress;
use App\Security\Domain\ValueObject\Password;
use App\Shared\Domain\ValueObject\Identifier;
use Serializable;

final class User implements Serializable
{
    public function __construct(public Identifier $identifier, public EmailAddress $email, public Password $password)
    {
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
        /** @var array<array-key, string> $unserializedData */
        $unserializedData = unserialize($data, ['allowed_classes' => false]);

        /**
         * @var string $identifier
         * @var string $email,
         * @var string $password
         */
        [
            $identifier,
            $email,
            $password,
        ] = $unserializedData;

        $this->identifier = Identifier::fromString($identifier);
        $this->email = new EmailAddress($email);
        $this->password = new Password($password);
    }
}
