<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\InMemory;

use App\Shared\Infrastructure\InMemory\Exception\RepositoryDoesNotExistsException;
use App\Shared\Infrastructure\InMemory\Repository\AbstractRepository;

final class Database implements DatabaseInterface
{
    /**
     * @var array<class-string, AbstractRepository<object>>
     */
    private array $repositories = [];

    public function getRepository(string $entity): AbstractRepository
    {
        if (!isset($this->repositories[$entity])) {
            throw new RepositoryDoesNotExistsException(sprintf('The repository for %s does not exist.', $entity));
        }

        return $this->repositories[$entity];
    }
}
