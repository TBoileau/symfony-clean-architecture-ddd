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

namespace App\Security\Domain\Contract\Gateway;

use App\Security\Domain\Entity\User;
use App\Shared\Domain\ValueObject\Email\EmailAddress;
use App\Shared\Domain\ValueObject\Token\UuidToken;

/**
 * @template T as User
 */
interface UserGateway
{
    public function getUserByEmail(EmailAddress $email): ?User;

    public function getUserByForgottenPasswordToken(UuidToken $token): ?User;

    public function update(User $user): void;
}
