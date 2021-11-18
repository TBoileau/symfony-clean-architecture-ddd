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

namespace App\Security\Infrastructure\Symfony\Security\User;

use App\Security\Domain\Contract\Gateway\UserGateway;
use App\Security\Domain\Entity\User;
use App\Shared\Domain\Exception\InvalidArgumentException;
use App\Shared\Domain\ValueObject\Email\EmailAddress;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class Provider implements UserProviderInterface
{
    /**
     * @param UserGateway<User> $userGateway
     */
    public function __construct(private UserGateway $userGateway)
    {
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return UserProxy::class === $class;
    }

    public function loadUserByUsername(string $username): UserInterface
    {
        return $this->loadUserByIdentifier($username);
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        try {
            $email = EmailAddress::createFromString($identifier);
        } catch (InvalidArgumentException) {
            throw new UserNotFoundException();
        }

        $user = $this->userGateway->getUserByEmail($email);

        if (null === $user) {
            throw new UserNotFoundException();
        }

        return new UserProxy($user);
    }
}
