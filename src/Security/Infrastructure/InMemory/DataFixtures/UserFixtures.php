<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\InMemory\DataFixtures;

use App\Security\Infrastructure\InMemory\Entity\UserEntity;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use TBoileau\InMemoryBundle\DatabaseInterface;
use TBoileau\InMemoryBundle\DataFixtures\FixtureInterface;

final class UserFixtures implements FixtureInterface
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function load(DatabaseInterface $database): void
    {
        $user = new UserEntity();
        $user->setEmail('user+1@email.com');
        $user->setIdentifier('f3fb19b8-ec93-4247-b0f8-3db786fdfa13');
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                new class() implements PasswordAuthenticatedUserInterface {
                    public function getPassword(): ?string
                    {
                        return null;
                    }
                },
                'password'
            )
        );
        $database->persist($user);

        $database->flush();
    }
}
