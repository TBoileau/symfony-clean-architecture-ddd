<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Symfony\Security\Authenticator\Passport;

use App\Security\Domain\PasswordHasher\PasswordHasherInterface;
use App\Security\Domain\ValueObject\Password\HashedPassword;
use App\Security\Domain\ValueObject\Password\PlainPassword;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CredentialsInterface;

final class PasswordCredentials implements CredentialsInterface
{
    private bool $resolved = false;

    public function __construct(private PlainPassword $plainPassword)
    {
    }

    public function verify(PasswordHasherInterface $passwordHasher, HashedPassword $hashedPassword): void
    {
        if (!$hashedPassword->verify($passwordHasher, $this->plainPassword)) {
            throw new BadCredentialsException('Invalid credentials.');
        }

        $this->resolved = true;
    }

    public function isResolved(): bool
    {
        return $this->resolved;
    }
}
