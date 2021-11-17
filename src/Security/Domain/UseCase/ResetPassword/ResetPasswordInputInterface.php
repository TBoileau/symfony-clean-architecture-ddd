<?php

declare(strict_types=1);

namespace App\Security\Domain\UseCase\ResetPassword;

use App\Security\Domain\Entity\User;
use App\Security\Domain\ValueObject\Password\PlainPassword;

interface ResetPasswordInputInterface
{
    public function plainPassword(): PlainPassword;

    public function user(): User;
}
