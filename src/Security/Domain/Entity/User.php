<?php

declare(strict_types=1);

namespace App\Security\Domain\Entity;

use App\Security\Domain\ValueObject\EmailAddress;
use App\Security\Domain\ValueObject\Password;
use App\Shared\Domain\ValueObject\Identifier;

final class User
{
    public Identifier $identifier;

    public EmailAddress $email;

    public Password $password;
}
