<?php

declare(strict_types=1);

namespace MartinGold\LinkedList;

use MartinGold\LinkedList\Comparator\Comparator;
use MartinGold\LinkedList\Comparator\NativeComparator;
use MartinGold\LinkedList\Exception\InvalidType;
use MartinGold\LinkedList\Exception\OutOfBounds;
use Traversable;

use function get_debug_type;
use function sprintf;

/**
 * SortedLinkedList decorator with runtime type checking.
 * If your codebase uses strict type-checker like Psalm or PHPStan
 * use @see SortedLinkedList instead. This class just wrapper with
 * runtime performance overhead.
 *
 * The type is inferred from first value inserted to the list.
 *
 * @template T
 * @implements Collection<T>
 */
final class StrictSortedLinkedList implements Collection
{
    /** @var SortedLinkedList<T> */
    private SortedLinkedList $list;

    private string|null $type = null;

    public function __construct(
        Comparator|null $comparator = null,
    ) {
        $this->list = new SortedLinkedList($comparator ?? new NativeComparator());
    }

    /**
     * @param T $value
     *
     * @throws InvalidType
     */
    public function insert($value): void
    {
        if (! $this->isValidType($value)) {
            throw new InvalidType(sprintf(
                'Cannot insert $value of \'%s\' type into collection of type \'%s\'',
                get_debug_type($value),
                $this->type ?? '',
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
     *
     * @throws InvalidType
     */
    public function contains(mixed $value): bool
    {
        if (! $this->isValidType($value)) {
            throw new InvalidType(sprintf(
                'Cannot check if $value of \'%s\' type is contained in collection of type \'%s\'',
                get_debug_type($value),
                $this->type ?? '',
            ));
        }

        return $this->list->contains($value);
    }

    /**
     * @return T
     *
     * @throws OutOfBounds
     */
    public function get(int $index): mixed
    {
        return $this->list->get($index);
    }

    /** @return Traversable<T> */
    public function getIterator(): Traversable
    {
        return $this->list->getIterator();
    }

    private function isValidType($value): bool
    {
        $this->type ??= get_debug_type($value);

        return get_debug_type($value) === $this->type;
    }
}
