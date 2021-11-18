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

namespace App\Security\UserInterface\Input;

use App\Security\Domain\UseCase\RequestForgottenPassword\RequestForgottenPasswordInputInterface;
use App\Shared\Domain\ValueObject\Email\EmailAddress;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

final class RequestForgottenPasswordInput implements RequestForgottenPasswordInputInterface
{
    #[NotBlank]
    #[Email]
    public string $email;

    public function email(): EmailAddress
    {
        return EmailAddress::createFromString($this->email);
    }
}
