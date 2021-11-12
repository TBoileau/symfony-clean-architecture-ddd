<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\InMemory\Repository;

use App\Shared\Domain\Common\Collection\IndexedCollection;
use Closure;

/**
 * @template T as object
 */
abstract class AbstractRepository
{
    protected IndexedCollection $collection;

    /**
     * @param class-string $entity
     */
    public function __construct(string $entity)
    {
        $this->collection = new IndexedCollection($entity);

        foreach ($this->registerIndexes() as $index => $callback) {
            $this->collection->addIndex($index, $callback);
        }
    }

    public function persist(object $entity): void
    {
        $this->collection->add($entity);
    }

    public function remove(object $entity): void
    {
        $this->collection->removeElement($entity);
    }

    /**
     * @return T|null
     */
    public function findOneBy(string $criterion, string|int|float|bool|null $value): ?object
    {
        $data = $this->collection->findByIndex($criterion, $value);

        if (0 === $data->count()) {
            return null;
        }

        /** @phpstan-ignore-next-line */
        return $data->first();
    }

    /**
     * @return array<array-key, T>
     */
    public function findBy(string $criterion, string|int|float|bool|null $value): array
    {
        /** @phpstan-ignore-next-line */
        return $this->collection->findByIndex($criterion, $value)->toArray();
    }

    /**
     * @return iterable<string, Closure>
     */
    protected function registerIndexes(): iterable
    {
        return [];
    }
}
