<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\InMemory\Repository;

use App\Security\Domain\Entity\User;
use App\Security\Domain\Gateway\UserGateway;
use App\Security\Domain\ValueObject\Password\HashedPassword;
use App\Security\Infrastructure\InMemory\Entity\UserEntity;
use App\Shared\Domain\ValueObject\Email\EmailAddress;
use App\Shared\Domain\ValueObject\Identifier\UuidIdentifier;
use TBoileau\InMemoryBundle\DatabaseInterface;
use TBoileau\InMemoryBundle\Repository\AbstractRepository;

/**
 * @method array<array-key, User> findBy(string $criterion, string|int|float|bool|null $value)
 * @method ?User            findOneBy(string $criterion, string|int|float|bool|null $value)
 *
 * @template-extends AbstractRepository<User>
 */
final class UserRepository extends AbstractRepository implements UserGateway
{
    public function __construct(DatabaseInterface $database)
    {
        parent::__construct($database, UserEntity::class);
    }

    public function getUserByEmail(string $email): ?User
    {
        /** @var ?UserEntity $userEntity */
        $userEntity = $this->findOneBy('email', $email);

        if (null === $userEntity) {
            return null;
        }

        return new User(
            UuidIdentifier::createFromString($userEntity->getIdentifier()),
            EmailAddress::createFromString($userEntity->getEmail()),
            HashedPassword::createFromString($userEntity->getPassword())
        );
    }
}
