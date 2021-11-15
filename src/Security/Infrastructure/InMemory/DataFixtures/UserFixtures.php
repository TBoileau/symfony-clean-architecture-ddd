<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\InMemory\DataFixtures;

use App\Security\Domain\PasswordHasher\PasswordHasherInterface;
use App\Security\Domain\ValueObject\Password\PlainPassword;
use App\Security\Infrastructure\InMemory\Entity\UserEntity;
use TBoileau\InMemoryBundle\DatabaseInterface;
use TBoileau\InMemoryBundle\DataFixtures\FixtureInterface;

final class UserFixtures implements FixtureInterface
{
    public function __construct(private PasswordHasherInterface $passwordHasher)
    {
    }

    public function load(DatabaseInterface $database): void
    {
        $user = new UserEntity();
        $user->setEmail('user+1@email.com');
        $user->setIdentifier('f3fb19b8-ec93-4247-b0f8-3db786fdfa13');
        $user->setPassword((string) PlainPassword::createFromString('password')->hash($this->passwordHasher));
        $database->persist($user);

        $database->flush();
    }
}
