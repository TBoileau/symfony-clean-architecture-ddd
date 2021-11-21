<?php

declare(strict_types=1);

namespace App\Security\Domain\UseCase\RequestForgottenPassword;

use App\Shared\Domain\ValueObject\Email\EmailAddress;

interface RequestForgottenPasswordInputInterface
{
    public function email(): EmailAddress;
}
