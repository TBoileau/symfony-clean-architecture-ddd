<?php

declare(strict_types=1);

namespace App\Security\Domain\UseCase\ResetPassword;

interface ResetPasswordInterface
{
    public function __invoke(ResetPasswordInputInterface $input): void;
}
