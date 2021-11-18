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

namespace App\Security\Infrastructure\Doctrine\DataFixtures;

use App\Security\Domain\Contract\Security\PasswordHasher\PasswordHasherInterface;
use App\Security\Domain\Entity\User;
use App\Security\Domain\ValueObject\Password\PlainPassword;
use App\Shared\Domain\ValueObject\Date\DateTime;
use App\Shared\Domain\ValueObject\Email\EmailAddress;
use App\Shared\Domain\ValueObject\Identifier\UuidIdentifier;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class UserFixtures extends Fixture
{
    public function __construct(private PasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $manager->persist($this->createUser(1));
        $manager->persist($this->createUser(2, expired: true));
        $manager->persist($this->createUser(3, suspended: true));

        $manager->flush();
    }

    public function createUser(int $index, bool $expired = false, bool $suspended = false): User
    {
        $user = User::create(
            identifier: UuidIdentifier::create(),
            email: EmailAddress::createFromString(sprintf('user+%d@email.com', $index)),
            plainPassword: PlainPassword::createFromString('password'),
            expiredAt: $expired ? DateTime::createFromString('2021-01-01 00:00:00') : null,
            suspendedAt: $suspended ? DateTime::createFromString('2021-01-01 00:00:00') : null
        );
        /** @var PlainPassword $plainPassword */
        $plainPassword = $user->plainPassword;
        $user->hashedPassword = $plainPassword->hash($this->passwordHasher);

        return $user;
    }
}
