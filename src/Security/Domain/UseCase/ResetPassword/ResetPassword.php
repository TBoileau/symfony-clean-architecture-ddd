<?php

declare(strict_types=1);

namespace App\Security\Domain\UseCase\ResetPassword;

use App\Security\Domain\Contract\Gateway\UserGateway;
use App\Security\Domain\Contract\Security\PasswordHasher\PasswordHasherInterface;
use App\Security\Domain\Entity\User;
use Exception;

final class ResetPassword implements ResetPasswordInterface
{
    /**
     * @param UserGateway<User> $userGateway
     */
    public function __construct(private UserGateway $userGateway, private PasswordHasherInterface $passwordHasher)
    {
    }

    public function __invoke(ResetPasswordInputInterface $input): void
    {
        $user = $input->user();

        if (!$user->canResetPassword()) {
            throw new Exception('You need to make a forgotten password request.');
        }

        $user->plainPassword = $input->plainPassword();
        $user->resetPassword($this->passwordHasher);
        $this->userGateway->update($user);
    }
}
