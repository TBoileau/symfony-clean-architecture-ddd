<?php

/**
 * Copyright (C) Thomas Boileau - All Rights Reserved.
 *
 * This source code is protected under international copyright law.
 * All rights reserved and protected by the copyright holders.
 * This file is confidential and only available to authorized individuals with the
 * permission of the copyright holders. If you encounter this file and do not have
 * permission, please contact the copyright holders and delete this file.
 */

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
