<?php

declare(strict_types=1);

namespace App\Security\Domain\UseCase\RequestForgottenPassword;

use App\Shared\Domain\Exception\InvalidArgumentException;

interface RequestForgottenPasswordInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function __invoke(
        RequestForgottenPasswordInputInterface $input,
        RequestForgottenPasswordPresenterInterface $presenter
    ): void;
}
