<?php

declare(strict_types=1);

namespace App\Security\Domain\UseCase\ResetPassword;

use App\Shared\Domain\Exception\InvalidArgumentException;

interface ResetPasswordInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function __invoke(ResetPasswordInputInterface $input): void;
}
