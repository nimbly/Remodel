<?php

namespace Remodel\Tests;

use PHPUnit\Framework\TestCase;
use Remodel\Resource\EmptyCollection;

/**
 * @covers Remodel\Resource\EmptyCollection
 */
class ResourceEmptyCollectionTest extends TestCase
{
    public function test_empty_collection_transformers_to_empty_array()
    {
        $emptyCollection = new EmptyCollection;
        $this->assertTrue(is_array($emptyCollection->toData()));
        $this->assertEmpty($emptyCollection->toData());
    }
}