<?php

declare(strict_types=1);

namespace App\Security\Domain\Entity;

use App\Security\Domain\ValueObject\Password\HashedPassword;
use App\Security\Domain\ValueObject\Password\PlainPassword;
use App\Shared\Domain\ValueObject\Email\EmailAddress;
use App\Shared\Domain\ValueObject\Identifier\UuidIdentifier;

final class User
{
    public function __construct(
        public UuidIdentifier $identifier,
        public EmailAddress $email,
        public ?HashedPassword $hashedPassword = null,
        public ?PlainPassword $plainPassword = null
    ) {
    }
}
