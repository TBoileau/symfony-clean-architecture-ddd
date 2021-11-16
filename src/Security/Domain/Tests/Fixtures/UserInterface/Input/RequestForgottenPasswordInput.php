<?php

declare(strict_types=1);

namespace App\Security\Domain\Tests\Fixtures\UserInterface\Input;

use App\Security\Domain\UseCase\RequestForgottenPassword\RequestForgottenPasswordInputInterface;
use App\Shared\Domain\ValueObject\Email\EmailAddress;

final class RequestForgottenPasswordInput implements RequestForgottenPasswordInputInterface
{
    public function __construct(private string $email)
    {
    }

    public function email(): EmailAddress
    {
        return EmailAddress::createFromString($this->email);
    }
}
