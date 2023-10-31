<?php

declare(strict_types=1);

use MartinGold\LinkedList\Exception\InvalidTypeException;
use MartinGold\LinkedList\StrictSortedLinkedList;
use PHPUnit\Framework\TestCase;

final class StrictSortedLinkedListTest extends TestCase
{
    public function testInsert(): void
    {
        $list = new StrictSortedLinkedList('int');
        $list->insert(1);

        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage('Cannot insert $value of \'string\' type into collection of type \'int\'');

        $list->insert('Hello!');
    }

    public function testContains(): void
    {
        $list = new StrictSortedLinkedList('int');
        $list->insert(1);

        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage('Cannot check if $value of \'string\' type is contained in collection of type \'int\'');

        $list->contains('Hello!');
    }
}
