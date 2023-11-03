<?php

declare(strict_types=1);

namespace MartinGold\LinkedList;

use MartinGold\LinkedList\Comparator\Comparator;
use MartinGold\LinkedList\Comparator\NativeComparator;
use MartinGold\LinkedList\Exception\OutOfBounds;
use Traversable;

use function sprintf;

/**
 * @template T
 * @implements Collection<T>
 */
final class SortedLinkedList implements Collection
{
    /** @var Node<T>|null */
    private Node|null $head = null;

    public function __construct(
        private readonly Comparator $comparator = new NativeComparator(),
    ) {
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
     * @throws OutOfBounds
     */
    public function shift(): mixed
    {
        if ($this->head === null) {
            throw new OutOfBounds('Cannot shift element on empty collection.');
        }

        $value = $this->head->getValue();

        $this->head = $this->head->getNext();

        return $value;
    }

    /**
     * @return T
     *
     * @throws OutOfBounds
     */
    public function pop(): mixed
    {
        $current = $this->head;
        if ($current === null) {
            throw new OutOfBounds('Cannot pop element on empty collection.');
        }

        if ($current->getNext() === null) {
            $value      = $current->getValue();
            $this->head = null;

            return $value;
        }

        while ($current->getNext()?->getNext() !== null) {
            $current = $current->getNext();
        }

        /** @psalm-suppress PossiblyNullReference Null checked in while loop */
        $value = $current->getNext()->getValue();
        $current->setNext(null);

        return $value;
    }

    /** @return Traversable<T> */
    public function getIterator(): Traversable
    {
        $current = $this->head;
        while ($current !== null) {
            yield $current->getValue();

            $current = $current->getNext();
        }
    }
}
