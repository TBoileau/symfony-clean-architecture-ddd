<?php

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
