<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\InMemory\Repository;

use App\Security\Domain\Entity\User;
use App\Security\Domain\Gateway\UserGateway;

final class UserRepository implements UserGateway
{
    /**
     * @var array<string, User>
     */
    private array $users;

    public function __construct()
    {

    }

    public function getUserByEmail(string $email): ?User
    {
        return $this->users[$email] ?? null;
    }
}
