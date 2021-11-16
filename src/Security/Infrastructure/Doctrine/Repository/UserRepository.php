<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Doctrine\Repository;

use App\Security\Domain\Entity\User;
use App\Security\Domain\Gateway\UserGateway;
use App\Shared\Domain\ValueObject\Email\EmailAddress;
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

    public function update(User $user): void
    {
        $this->_em->flush($user);
    }
}
