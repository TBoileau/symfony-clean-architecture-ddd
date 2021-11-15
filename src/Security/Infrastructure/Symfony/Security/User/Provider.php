<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Symfony\Security\User;

use App\Security\Domain\Gateway\UserGateway;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class Provider implements UserProviderInterface
{
    public function __construct(private UserGateway $userGateway)
    {
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return UserProxy::class === $class;
    }

    public function loadUserByUsername(string $username): UserInterface
    {
        return $this->loadUserByIdentifier($username);
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->userGateway->getUserByEmail($identifier);

        if (null === $user) {
            throw new UserNotFoundException();
        }

        return new UserProxy($user);
    }
}
