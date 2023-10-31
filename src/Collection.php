<?php

declare(strict_types=1);

namespace MartinGold\LinkedList;

use Iterator;

/**
 * @template T
 * @extends  Iterator<T>
 */
interface Collection extends Iterator
{

    /**
     * @param T $value
     */
    public function insert($value): void;

    public function length(): int;

    /**
     * @return T
     */
    public function get(int $index): mixed;

    /**
     * @param T $value
     */
    public function contains(mixed $value): bool;

    /**
     * @return T
     */
    public function current(): mixed;

    public function key(): int;

    public function next(): void;

    public function valid(): bool;

    public function rewind(): void;
}