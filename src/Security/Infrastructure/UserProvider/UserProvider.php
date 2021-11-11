<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\UserProvider;

use App\Security\Domain\Gateway\UserGateway;
use App\Security\Infrastructure\Model\SymfonyUser;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class UserProvider implements UserProviderInterface
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

    }

    public function loadUserByUsername(string $username): UserInterface
    {
        return $this->loadUserByIdentifier($username);
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->userGateway->getUserByEmail($identifier);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        return new SymfonyUser($user);
    }
}
