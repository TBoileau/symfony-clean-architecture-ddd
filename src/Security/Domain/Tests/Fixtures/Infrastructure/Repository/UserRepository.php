<?php

/**
 * Copyright (C) Thomas Boileau - All Rights Reserved.
 *
 * This source code is protected under international copyright law.
 * All rights reserved and protected by the copyright holders.
 * This file is confidential and only available to authorized individuals with the
 * permission of the copyright holders. If you encounter this file and do not have
 * permission, please contact the copyright holders and delete this file.
 */

declare(strict_types=1);

namespace App\Security\Domain\Tests\Fixtures\Infrastructure\Repository;

use App\Security\Domain\Contract\Gateway\UserGateway;
use App\Security\Domain\Entity\User;
use App\Shared\Domain\ValueObject\Email\EmailAddress;
use App\Shared\Domain\ValueObject\Token\UuidToken;

/**
 * @template-implements UserGateway<User>
 */
final class UserRepository implements UserGateway
{
    /**
     * @param array<int, User> $users
     */
    public function __construct(public array $users)
    {
    }

    public function getUserByEmail(EmailAddress $email): ?User
    {
        /** @var array<int, User> $users */
        $users = array_filter($this->users, static fn (User $user) => $user->email->equalTo($email));

        return $users[0] ?? null;
    }

    public function getUserByForgottenPasswordToken(UuidToken $token): ?User
    {
        /** @var array<int, User> $users */
        $users = array_filter(
            $this->users,
            static fn (User $user) => null !== $user->forgottenPasswordToken
                && $user->forgottenPasswordToken->equalTo($token)
        );

        return $users[0] ?? null;
    }

    public function update(User $user): void
    {
    }
}
