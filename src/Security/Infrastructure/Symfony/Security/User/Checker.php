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

namespace App\Security\Infrastructure\Symfony\Security\User;

use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class Checker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof UserProxy) {
            return;
        }

        if ($user->user->isSupended()) {
            throw new CustomUserMessageAccountStatusException('Your user account has been suspended.');
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
        if (!$user instanceof UserProxy) {
            return;
        }

        // user account is expired, the user may be notified
        if ($user->user->isExpired()) {
            throw new AccountExpiredException();
        }
    }
}
