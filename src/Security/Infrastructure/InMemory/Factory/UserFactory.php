<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\InMemory\Factory;

use App\Security\Domain\Entity\User;
use App\Security\Domain\ValueObject\EmailAddress;
use App\Security\Domain\ValueObject\Password;
use App\Security\Infrastructure\InMemory\Repository\UserRepository;
use App\Shared\Domain\ValueObject\Identifier;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<User>
 *
 * @method static     array<array-key, User|Proxy> createMany(int $number, array|callable $attributes = [])
 * @method static     UserRepository|RepositoryProxy repository()
 * @method User|Proxy create(array|callable $attributes = [])
 */
final class UserFactory extends ModelFactory
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
        parent::__construct();
    }

    protected static function getClass(): string
    {
        return User::class;
    }

    /**
     * @return array{identifier: Identifier, email: EmailAddress, password: Password}
     */
    protected function getDefaults(): array
    {
        return [
            'identifier' => new Identifier(Uuid::v4()),
            'email' => new EmailAddress('user+1@email.com'),
            'password' => new Password(
                $this->userPasswordHasher->hashPassword(
                    new class() implements PasswordAuthenticatedUserInterface {
                        public function getPassword(): ?string
                        {
                            return null;
                        }
                    },
                    'password'
                )
            ),
        ];
    }
}
