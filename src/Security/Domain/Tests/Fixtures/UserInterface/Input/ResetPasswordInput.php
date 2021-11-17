<?php

declare(strict_types=1);

namespace App\Security\Domain\Tests\Fixtures\UserInterface\Input;

use App\Security\Domain\Entity\User;
use App\Security\Domain\UseCase\ResetPassword\ResetPasswordInputInterface;
use App\Security\Domain\ValueObject\Password\PlainPassword;

final class ResetPasswordInput implements ResetPasswordInputInterface
{
    public function __construct(private string $password, private User $user)
    {
    }

    public function plainPassword(): PlainPassword
    {
        return PlainPassword::createFromString($this->password);
    }

    public function user(): User
    {
        return $this->user;
    }
}
