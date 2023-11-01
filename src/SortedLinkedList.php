<?php

declare(strict_types=1);

namespace MartinGold\LinkedList;

use LogicException;
use MartinGold\LinkedList\Comparator\Comparator;
use MartinGold\LinkedList\Comparator\NativeComparator;
use MartinGold\LinkedList\Exception\OutOfBounds;

use function sprintf;

/**
 * @template T
 * @implements Collection<T>
 */
final class SortedLinkedList implements Collection
{
    /** @var Node<T>|null */
    private Node|null $head = null;

    /** @var Node<T>|null */
    private Node|null $iteratorPointer;

    private int $iteratorIndex = 0;

    private Comparator $comparator;

    public function __construct(
        Comparator|null $comparator = null,
    ) {
        $this->comparator = $comparator ?? new NativeComparator();
    }

    /** @param T $value */
    public function insert($value): void
    {
        $newNode = new Node($value);

        // Make the new node head of list if empty
        if ($this->head === null) {
            $this->head = $newNode;

            return;
        }

        // Make the new node head if greater than current head
        if ($this->comparator->compare($value, $this->head->getValue()) < 0) {
            $newNode->setNext($this->head);
            $this->head = $newNode;

            return;
        }

        // List is not empty and value is not lesser than head
        // Find node in the list after which the new node should be inserted.
        $current = $this->head;

        /** @psalm-suppress PossiblyNullReference Node::getNext() has no side-effect */
        while ($current->getNext() !== null && $this->comparator->compare($value, $current->getNext()->getValue()) > 0) {
            $current = $current->getNext();
        }

        // Insert the node
        $newNode->setNext($current->getNext());
        $current->setNext($newNode);
    }

    public function length(): int
    {
        $current = $this->head;
        $count   = 0;

        while ($current !== null) {
            $count++;
            $current = $current->getNext();
        }

        return $count;
    }

    /** @param T $value */
    public function contains(mixed $value): bool
    {
        $current = $this->head;

        while ($current !== null) {
            if ($this->comparator->compare($value, $current->getValue()) === 0) {
                return true;
            }

            $current = $current->getNext();
        }

        return false;
    }

    /**
     * @return T
     *
     * @throws OutOfBounds
     */
    public function get(int $index): mixed
    {
        $current = $this->head;
        $count   = 0;

        while ($current !== null && $count < $index) {
            $current = $current->getNext();
            $count++;
        }

        if ($current === null) {
            throw new OutOfBounds(sprintf(
                'Trying to access index %s. List has only %s elements.',
                $index,
                $this->length(),
            ));
        }

        return $current->getValue();
    }

    /**
     * @return T
     *
     * @throws LogicException
     */
    public function current(): mixed
    {
        if ($this->iteratorPointer === null) {
            throw new LogicException('Current node is null');
        }

        return $this->iteratorPointer->getValue();
    }

    public function key(): int
    {
        return $this->iteratorIndex;
    }

    public function next(): void
    {
        $next = $this->iteratorPointer?->getNext();

        $this->iteratorIndex++;
        $this->iteratorPointer = $next;
    }

    public function valid(): bool
    {
        return $this->iteratorPointer !== null;
    }

    public function rewind(): void
    {
        $this->iteratorIndex   = 0;
        $this->iteratorPointer = $this->head;
    }
}
