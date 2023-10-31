<?php

declare(strict_types=1);

namespace MartinGold\LinkedList\Comparator;

/**
 * @template T
 * @implements Comparator<T>
 */
class NativeComparator implements Comparator
{
    /**
     * @param T $a
     * @param T $b
     * @return int<-1, 1>
     */
    public function compare($a, $b): int
    {
        return $a <=> $b;
    }
}