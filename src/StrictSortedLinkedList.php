<?php

declare(strict_types=1);

namespace MartinGold\LinkedList;

use MartinGold\LinkedList\Comparator\Comparator;
use MartinGold\LinkedList\Comparator\NativeComparator;
use MartinGold\LinkedList\Exception\InvalidTypeException;
use MartinGold\LinkedList\Exception\OutOfBoundsException;

/**
 * SortedLinkedList decorator with runtime type checking.
 * If your codebase uses strict type-checker like Psalm or PHPStan
 * use @see SortedLinkedList instead. This class just wrapper with
 * runtime performance overhead.
 *
 * @template T
 * @implements Collection<T>
 */
final class StrictSortedLinkedList implements Collection
{

    /**
     * @var SortedLinkedList<T>
     */
    private SortedLinkedList $list;

    /**
     * @param Comparator|null $comparator
     * @param class-string<T> $type
     */
    public function __construct(
        readonly private string $type,
        Comparator|null $comparator = null,
    ) {
        $this->list = new SortedLinkedList($comparator ?? new NativeComparator());
    }

    /**
     * @param T $value
     *
     * @throws InvalidTypeException
     */
    public function insert($value): void {
        if (!$this->isValidType($value)) {
            throw new InvalidTypeException(sprintf(
                'Cannot insert $value of \'%s\' type into collection of type \'%s\'',
                get_debug_type($value),
                $this->type,
            ));
        }

        $this->list->insert($value);
    }

    public function length(): int
    {
        return $this->list->length();
    }

    /**
     * @param T $value
     * @throws InvalidTypeException
     */
    public function contains(mixed $value): bool
    {
        if (!$this->isValidType($value)) {
            throw new InvalidTypeException(sprintf(
                'Cannot check if $value of \'%s\' type is contained in collection of type \'%s\'',
                get_debug_type($value),
                $this->type,
            ));
        }

        return $this->list->contains($value);
    }

    /**
     * @return T
     *
     * @throws OutOfBoundsException
     */
    public function get(int $index): mixed
    {
        return $this->list->get($index);
    }

    /**
     * @return T
     */
    public function current(): mixed
    {
        return $this->list->current();
    }

    public function key(): int
    {
        return $this->list->key();
    }

    public function next(): void
    {
        $this->list->next();
    }

    public function valid(): bool
    {
        return $this->list->valid();
    }

    public function rewind(): void
    {
        $this->list->rewind();
    }

    private function isValidType(mixed $value): bool
    {
        return get_debug_type($value) === $this->type;
    }
}