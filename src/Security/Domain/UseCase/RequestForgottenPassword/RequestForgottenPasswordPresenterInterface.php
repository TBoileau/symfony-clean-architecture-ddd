<?php

declare(strict_types=1);

namespace App\Security\Domain\UseCase\RequestForgottenPassword;

interface RequestForgottenPasswordPresenterInterface
{
    public function present(RequestForgottenPasswordOutput $output): void;
}
