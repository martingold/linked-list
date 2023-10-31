<?php

declare(strict_types=1);

namespace MartinGold\LinkedList\Comparator;

/**
 * @template T
 */
interface Comparator
{

    /**
     * Mimics spaceship operator behaviour.
     * Return 1 when $a value is greater than $b
     * Return 0 when $a value is same as $b value
     * Return -1 when $a value is lesser than $b
     *
     * @param T $a
     * @param T $b
     * @return int<-1, 1>
     */
    public function compare($a, $b): int;

}