<?php

declare(strict_types=1);

namespace App\Security\Domain\Gateway;

use App\Security\Domain\Entity\User;
use App\Shared\Domain\ValueObject\Email\EmailAddress;

/**
 * @template T as User
 */
interface UserGateway
{
    public function getUserByEmail(EmailAddress $email): ?User;

    public function update(User $user): void;
}
