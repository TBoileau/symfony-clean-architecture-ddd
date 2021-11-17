<?php

declare(strict_types=1);

namespace App\Security\Domain\Contract\Gateway;

use App\Security\Domain\Entity\User;
use App\Shared\Domain\ValueObject\Email\EmailAddress;
use App\Shared\Domain\ValueObject\Token\UuidToken;

/**
 * @template T as User
 */
interface UserGateway
{
    public function getUserByEmail(EmailAddress $email): ?User;

    public function getUserByForgottenPasswordToken(UuidToken $token): ?User;

    public function update(User $user): void;
}
