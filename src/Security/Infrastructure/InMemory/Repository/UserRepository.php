<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\InMemory\Repository;

use App\Security\Domain\Entity\User;
use App\Security\Domain\Gateway\UserGateway;
use App\Shared\Infrastructure\InMemory\Repository\AbstractRepository;
use Closure;

/**
 * @method array<array-key, User> findBy(string $criterion, string|int|float|bool|null $value)
 * @method ?User            findOneBy(string $criterion, string|int|float|bool|null $value)
 *
 * @template-extends AbstractRepository<User>
 */
final class UserRepository extends AbstractRepository implements UserGateway
{
    public function __construct()
    {
        parent::__construct(User::class);
    }

    public function getUserByEmail(string $email): ?User
    {
        return $this->findOneBy('email', $email);
    }

    /**
     * @return iterable<string, Closure>
     */
    protected function registerIndexes(): iterable
    {
        yield 'identifier' => static fn (User $user): string => (string) $user->identifier;
        yield 'email' => static fn (User $user): string => (string) $user->email;
    }
}
