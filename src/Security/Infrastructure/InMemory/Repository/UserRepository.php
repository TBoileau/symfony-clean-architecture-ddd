<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\InMemory\Repository;

use App\Security\Domain\Entity\User;
use App\Security\Domain\Gateway\UserGateway;
use App\Shared\Infrastructure\InMemory\DatabaseInterface;
use App\Shared\Infrastructure\InMemory\Repository\AbstractRepository;

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
        parent::__construct($database, User::class);
    }

    public function getUserByEmail(string $email): ?User
    {
        return $this->findOneBy('email', $email);
    }
}
