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

use App\Security\Domain\Entity\User;
use App\Security\Domain\ValueObject\Password\HashedPassword;
use App\Shared\Domain\ValueObject\Email\EmailAddress;
use App\Shared\Domain\ValueObject\Identifier\UuidIdentifier;
use Serializable;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserProxy implements Serializable, UserInterface, PasswordAuthenticatedUserInterface, EquatableInterface
{
    public function __construct(public User $user)
    {
    }

    /**
     * @return array<array-key, string>
     */
    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getPassword(): string
    {
        return (string) $this->user->hashedPassword;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
        $this->user->plainPassword = null;
    }

    public function getUsername(): string
    {
        return (string) $this->user->email;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->user->email;
    }

    public function isEqualTo(UserInterface $user): bool
    {
        if (!$user instanceof UserProxy) {
            return false;
        }

        return $user->getUserIdentifier() === $this->getUserIdentifier()
            && $user->user->isSupended() === $this->user->isSupended()
            && $user->user->isExpired() === $this->user->isExpired();
    }

    public function serialize(): string
    {
        return serialize([
            (string) $this->user->identifier,
            (string) $this->user->email,
            (string) $this->user->hashedPassword,
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

        $this->user = User::create(
            UuidIdentifier::createFromString($identifier),
            EmailAddress::createFromString($email),
            HashedPassword::createFromString($password)
        );
    }
}
