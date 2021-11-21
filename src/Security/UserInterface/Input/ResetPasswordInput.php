<?php

declare(strict_types=1);

namespace App\Security\UserInterface\Input;

use App\Security\Domain\Entity\User;
use App\Security\Domain\UseCase\ResetPassword\ResetPasswordInputInterface;
use App\Security\Domain\ValueObject\Password\PlainPassword;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ResetPasswordInput implements ResetPasswordInputInterface
{
    #[NotBlank]
    public string $password;

    public function __construct(private User $user)
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
