<?php

declare(strict_types=1);

namespace App\Shared\Domain\Common\Collection;

use App\Shared\Domain\Common\Collection\Exception\NotAllowedToIndexException;
use App\Shared\Domain\Common\Collection\Exception\WrongTypeException;
use Closure;

interface Collection
{
    /**
     * @throws NotAllowedToIndexException
     * @throws WrongTypeException
     */
    public function addIndex(string $name, Closure $callback): void;

    public function findByIndex(string $index, mixed $value): Collection;
}
