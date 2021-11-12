<?php

declare(strict_types=1);

namespace App\Security\Domain\Gateway;

use App\Security\Domain\Entity\User;

interface UserGateway
{
    public function getUserByEmail(string $email): ?User;
}
