<?php

declare(strict_types=1);

namespace App\Security\Infrastructure;

use App\Security\Domain\Entity\User as DomainUser;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class User implements UserInterface, PasswordAuthenticatedUserInterface, EquatableInterface
{
    private DomainUser $user;

    public function __construct(DomainUser $user)
    {
        $this->user = $user;
    }

    /**
     * @return array<array-key, string>
     */
    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getPassword(): string
    {
        return (string) $this->user->password;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUsername(): string
    {
        return (string) $this->user->email;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->user->email;
    }

    public function isEqualTo(UserInterface $user): bool
    {
        return $user->getUserIdentifier() === $this->getUserIdentifier();
    }
}
