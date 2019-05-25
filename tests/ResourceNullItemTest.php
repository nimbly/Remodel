<?php

namespace Remodel\Tests;

use PHPUnit\Framework\TestCase;
use Remodel\Resource\NullItem;

/**
 * @covers Remodel\Resource\NullItem
 */
class ResourceNullItemTest extends TestCase
{
    public function test_null_item_transforms_to_null()
    {
        $nullItem = new NullItem;
        $this->assertNull($nullItem->toData());
    }
}