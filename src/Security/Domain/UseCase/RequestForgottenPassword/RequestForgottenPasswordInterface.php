<?php

declare(strict_types=1);

namespace App\Security\Domain\UseCase\RequestForgottenPassword;

interface RequestForgottenPasswordInterface
{
    /**
     * @throw InvalidArgumentException
     */
    public function __invoke(
        RequestForgottenPasswordInputInterface $input,
        RequestForgottenPasswordPresenterInterface $presenter
    ): void;
}
