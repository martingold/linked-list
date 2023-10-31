<?php declare(strict_types=1);

use MartinGold\LinkedList\SortedLinkedList;
use MartinGold\LinkedList\Exception\OutOfBoundsException;
use PHPUnit\Framework\TestCase;

final class SortedLinkedListTest extends TestCase
{
    public function testInsert(): void
    {
        $list = new SortedLinkedList();
        $list->insert(1);
        $list->insert(2);
        $list->insert(3);

        $this->assertEquals([1, 2, 3], iterator_to_array($list));
    }

    public function testSortedOrder(): void
    {
        $list = new SortedLinkedList();
        $list->insert(3);
        $list->insert(1);
        $list->insert(5);
        $list->insert(2);
        $list->insert(4);

        $this->assertSame([1, 2, 3, 4, 5], iterator_to_array($list));
    }

    public function testGet(): void
    {
        $list = new SortedLinkedList();
        $list->insert(1);
        $list->insert(3);
        $list->insert(5);
        $list->insert(7);
        $list->insert(9);

        $this->assertSame(1, $list->get(0));
        $this->assertSame(7, $list->get(3));
        $this->assertSame(9, $list->get(4));
    }

    public function testContains(): void
    {
        $list = new SortedLinkedList();
        $list->insert(1);

        $this->assertTrue($list->contains(1));
        $this->assertFalse($list->contains(2));
    }

    public function testThrowsOutOfBoundsException(): void
    {
        $list = new SortedLinkedList();
        $list->insert(1);
        $list->insert(2);

        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('Trying to access index 3. List has only 2 elements.');

        $list->get(3);
    }
}