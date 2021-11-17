<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Doctrine\Repository;

use App\Security\Domain\Contract\Gateway\UserGateway;
use App\Security\Domain\Entity\User;
use App\Shared\Domain\ValueObject\Email\EmailAddress;
use App\Shared\Domain\ValueObject\Token\UuidToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends ServiceEntityRepository<User>
 *
 * @template-implements UserGateway<User>
 */
final class UserRepository extends ServiceEntityRepository implements UserGateway
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getUserByEmail(EmailAddress $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function getUserByForgottenPasswordToken(UuidToken $token): ?User
    {
        return $this->findOneBy(['forgottenPasswordToken' => $token]);
    }

    public function update(User $user): void
    {
        $this->_em->flush($user);
    }
}
