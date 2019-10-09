<?php

namespace Remodel\Tests;

use PHPUnit\Framework\TestCase;
use Remodel\Subjects\EmptyCollection;

/**
 * @covers Remodel\Subjects\EmptyCollection
 */
class ResourceEmptyCollectionTest extends TestCase
{
    public function test_empty_collection_transformers_to_empty_array()
    {
        $emptyCollection = new EmptyCollection;
        $this->assertTrue(\is_array($emptyCollection->remodel()));
        $this->assertEmpty($emptyCollection->remodel());
    }
}