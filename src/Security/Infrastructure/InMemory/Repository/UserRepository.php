<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\InMemory\Repository;

use App\Security\Domain\Entity\User;
use App\Security\Domain\Gateway\UserGateway;
use App\Security\Infrastructure\InMemory\Factory\UserFactory;

final class UserRepository implements UserGateway
{
    public function getUserByEmail(string $email): ?User
    {
        return UserFactory::createOne()->object();
    }
}
