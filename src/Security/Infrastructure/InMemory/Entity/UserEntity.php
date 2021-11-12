<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\InMemory\Entity;

use App\Security\Infrastructure\InMemory\Repository\UserRepository;
use TBoileau\InMemoryBundle\Mapping\Column;
use TBoileau\InMemoryBundle\Mapping\Entity;

#[Entity(name: 'user', repositoryClass: UserRepository::class)]
final class UserEntity
{
    #[Column(name: 'identifier', type: 'string', index: true)]
    private string $identifier;

    #[Column(name: 'email', type: 'string', index: true)]
    private string $email;

    #[Column(name: 'password', type: 'string')]
    private string $password;

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}
