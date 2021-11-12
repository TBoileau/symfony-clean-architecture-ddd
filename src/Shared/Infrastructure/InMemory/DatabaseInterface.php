<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\InMemory;

use App\Shared\Infrastructure\InMemory\Repository\AbstractRepository;

interface DatabaseInterface
{
    /**
     * @param class-string $entity
     *
     * @return AbstractRepository<object>
     *
     * @throw RepositoryDoesNotExistsException
     */
    public function getRepository(string $entity): AbstractRepository;
}
