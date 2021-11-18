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

namespace App\Security\Domain\UseCase\ResetPassword;

use App\Security\Domain\Contract\Gateway\UserGateway;
use App\Security\Domain\Contract\Security\PasswordHasher\PasswordHasherInterface;
use App\Security\Domain\Entity\User;
use Exception;

final class ResetPassword implements ResetPasswordInterface
{
    /**
     * @param UserGateway<User> $userGateway
     */
    public function __construct(private UserGateway $userGateway, private PasswordHasherInterface $passwordHasher)
    {
    }

    public function __invoke(ResetPasswordInputInterface $input): void
    {
        $user = $input->user();

        if (!$user->canResetPassword()) {
            throw new Exception('You need to make a forgotten password request.');
        }

        $user->plainPassword = $input->plainPassword();
        $user->resetPassword($this->passwordHasher);
        $this->userGateway->update($user);
    }
}
