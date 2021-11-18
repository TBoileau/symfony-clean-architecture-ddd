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

namespace App\Shared\Domain\ValueObject\Email;

use App\Shared\Domain\Exception\InvalidArgumentException;
use Stringable;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Validation;

class EmailAddress implements Stringable
{
    private function __construct(private string $email)
    {
        if (Validation::createValidator()->validate($this->email, [new Email()])->count() > 0) {
            throw new InvalidArgumentException(sprintf('%s is not a valid email', $this->email));
        }
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public static function createFromString(string $email): EmailAddress
    {
        return new EmailAddress($email);
    }

    public function equalTo(EmailAddress $email): bool
    {
        return (string) $email === (string) $this;
    }
}
