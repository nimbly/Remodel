<?php

namespace Remodel\Tests;

use PHPUnit\Framework\TestCase;
use Remodel\Subjects\NullItem;

/**
 * @covers Remodel\Subjects\NullItem
 */
class SubjectNullItemTest extends TestCase
{
    public function test_null_item_transforms_to_null()
    {
        $nullItem = new NullItem;
        $this->assertNull($nullItem->remodel());
    }
}