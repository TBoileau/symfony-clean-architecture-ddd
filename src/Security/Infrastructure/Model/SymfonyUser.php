<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Model;

use App\Security\Domain\Entity\User;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class SymfonyUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    private User $user;

    public function __construct(User $user)
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
}
