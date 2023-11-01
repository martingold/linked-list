<?php

declare(strict_types=1);

namespace MartinGold\LinkedList;

use IteratorAggregate;

/**
 * @template T
 * @extends  IteratorAggregate<T>
 */
interface Collection extends IteratorAggregate
{
    /** @param T $value */
    public function insert($value): void;

    public function length(): int;

    /** @return T */
    public function get(int $index): mixed;

    /** @param T $value */
    public function contains(mixed $value): bool;
}
