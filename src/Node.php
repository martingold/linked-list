<?php

declare(strict_types=1);

namespace MartinGold\LinkedList;

/** @template T */
final class Node
{
    /** @var Node<T>|null */
    private Node|null $next;

    /** @param T $value */
    public function __construct(private $value)
    {
        $this->next = null;
    }

    /** @return T */
    public function getValue()
    {
        return $this->value;
    }

    /** @return Node<T>|null */
    public function getNext(): Node|null
    {
        return $this->next;
    }

    /** @param Node<T>|null $next */
    public function setNext(Node|null $next): void
    {
        $this->next = $next;
    }
}
