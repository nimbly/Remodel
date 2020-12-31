<?php

namespace Nimbly\Remodel\Tests;

use PHPUnit\Framework\TestCase;
use Nimbly\Remodel\Subjects\NullItem;

/**
 * @covers Nimbly\Remodel\Subjects\NullItem
 */
class SubjectNullItemTest extends TestCase
{
    public function test_null_item_transforms_to_null(): void
    {
        $nullItem = new NullItem;
        $this->assertNull($nullItem->remodel());
    }
}