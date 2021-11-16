<?php

declare(strict_types=1);

namespace App\Security\Domain\UseCase\RequestForgottenPassword;

use App\Security\Domain\Entity\User;
use App\Security\Domain\Gateway\UserGateway;
use App\Shared\Domain\Exception\InvalidArgumentException;

final class RequestForgottenPassword implements RequestForgottenPasswordInterface
{
    /**
     * @param UserGateway<User> $userGateway
     */
    public function __construct(private UserGateway $userGateway)
    {
    }

    public function __invoke(
        RequestForgottenPasswordInputInterface $input,
        RequestForgottenPasswordPresenterInterface $presenter
    ): void {
        $user = $this->userGateway->getUserByEmail($input->email());

        if (null === $user) {
            throw new InvalidArgumentException('This email does not exist.');
        }

        if ($user->canResetPassword()) {
            throw new InvalidArgumentException('You have already request for a forgotten password last 24 hours.');
        }

        $user->requestForAForgottenPassword();

        $this->userGateway->update($user);

        $presenter->present(new RequestForgottenPasswordOutput($user));
    }
}
