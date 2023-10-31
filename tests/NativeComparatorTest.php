<?php

declare(strict_types=1);

use MartinGold\LinkedList\Comparator\NativeComparator;
use PHPUnit\Framework\TestCase;

final class NativeComparatorTest extends TestCase
{
    public function testIntegerCompare(): void
    {
        $comparator = new NativeComparator();

        $this->assertSame(-1, $comparator->compare(2, 5));
        $this->assertSame(0, $comparator->compare(1, 1));
        $this->assertSame(1, $comparator->compare(6, 3));
    }
}
