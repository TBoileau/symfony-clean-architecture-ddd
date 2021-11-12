<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\InMemory\Repository;

use App\Security\Domain\Entity\User;
use App\Security\Domain\Gateway\UserGateway;
use App\Security\Infrastructure\InMemory\Factory\UserFactory;

final class UserRepository implements UserGateway
{
    /**
     * @var array<string, User>
     */
    private array $users;

    public function __construct()
    {
        /** @var User $user */
        $user = UserFactory::createOne()->object();
        $this->users[(string) $user->email] = $user;
    }

    public function getUserByEmail(string $email): ?User
    {
        return $this->users[$email] ?? null;
    }
}
