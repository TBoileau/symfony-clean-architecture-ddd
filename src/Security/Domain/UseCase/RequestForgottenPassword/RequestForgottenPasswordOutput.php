<?php

declare(strict_types=1);

namespace App\Security\Domain\UseCase\RequestForgottenPassword;

use App\Security\Domain\Entity\User;

final class RequestForgottenPasswordOutput
{
    public function __construct(public User $user)
    {
    }
}
