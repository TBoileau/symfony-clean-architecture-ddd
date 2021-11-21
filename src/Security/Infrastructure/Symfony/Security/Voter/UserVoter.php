<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Symfony\Security\Voter;

use App\Security\Domain\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class UserVoter extends Voter
{
    public const CAN_RESET_PASSWORD = 'reset';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return $subject instanceof User;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        /** @var User $user */
        $user = $subject;

        return $user->canResetPassword();
    }
}
