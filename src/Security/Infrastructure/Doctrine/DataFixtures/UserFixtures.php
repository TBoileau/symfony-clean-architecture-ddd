<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Doctrine\DataFixtures;

use App\Security\Domain\Entity\User;
use App\Security\Domain\PasswordHasher\PasswordHasherInterface;
use App\Security\Domain\ValueObject\Password\PlainPassword;
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
        $user = User::create(
            identifier: UuidIdentifier::create(),
            email: EmailAddress::createFromString('user+1@email.com'),
            plainPassword: PlainPassword::createFromString('password')
        );

        /** @var PlainPassword $plainPassword */
        $plainPassword = $user->plainPassword;

        $user->hashedPassword = $plainPassword->hash($this->passwordHasher);

        $manager->persist($user);

        $manager->flush();
    }
}
