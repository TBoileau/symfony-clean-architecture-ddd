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

namespace App\Security\Domain\Contract\Security\PasswordHasher;

use App\Security\Domain\ValueObject\Password\HashedPassword;
use App\Security\Domain\ValueObject\Password\PlainPassword;

interface PasswordHasherInterface
{
    public function hashPassword(PlainPassword $plainPassword): HashedPassword;

    public function verifyPassword(HashedPassword $hashedPassword, PlainPassword $plainPassword): bool;
}
