<?php

declare(strict_types=1);

namespace App\Shared\Tests\Unit\Common;

use App\Shared\Domain\Common\Collection\Exception\NotAllowedToIndexException;
use App\Shared\Domain\Common\Collection\Exception\WrongTypeException;
use App\Shared\Domain\Common\Collection\IndexedCollection;
use PHPUnit\Framework\TestCase;
use stdClass;

final class IndexedCollectionTest extends TestCase
{
    public function testIfFindByIndexReturnsData(): void
    {
        $collection = new IndexedCollection(stdClass::class);

        $collection->addIndex('bar', static fn (stdClass $foo): string => $foo->bar['qux']);

        $foo1 = new stdClass();
        $foo1->bar = ['qux' => 'corge'];
        $collection->add($foo1);

        $foo2 = new stdClass();
        $foo2->bar = ['qux' => 'grault'];
        $collection->add($foo2);

        $this->assertCount(1, $collection->findByIndex('bar', 'corge'));
        $this->assertContains($foo1, $collection->findByIndex('bar', 'corge'));
    }

    public function testIfAddNonObjectElementRaiseException(): void
    {
        $collection = new IndexedCollection(stdClass::class);

        $collection->addIndex('bar', static fn (stdClass $foo): string => $foo->bar['qux']);

        $this->expectException(WrongTypeException::class);

        $collection->add(false);
    }

    public function testIfAddElementBeforeAddingIndexRaiseException(): void
    {
        $collection = new IndexedCollection(stdClass::class);

        $foo1 = new stdClass();
        $foo1->bar = ['qux' => 'corge'];
        $collection->add($foo1);

        $this->expectException(NotAllowedToIndexException::class);

        $collection->addIndex('bar', static fn (stdClass $foo): string => $foo->bar['qux']);
    }

    public function testIfIndexCallbackDoesNotReturnScalarRaiseException(): void
    {
        $collection = new IndexedCollection(stdClass::class);

        $this->expectException(WrongTypeException::class);

        $collection->addIndex('bar', static fn (stdClass $foo): stdClass => $foo);
    }

    public function testIfIndexCallbackReturnUnionTypesRaiseException(): void
    {
        $collection = new IndexedCollection(stdClass::class);

        $this->expectException(WrongTypeException::class);

        $collection->addIndex('bar', static fn (stdClass $foo): int|string => $foo->bar['qux']);
    }
}
