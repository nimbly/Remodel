<?php

namespace Nimbly\Remodel\Tests;

use PHPUnit\Framework\TestCase;
use Nimbly\Remodel\Subjects\EmptyCollection;

/**
 * @covers Nimbly\Remodel\Subjects\EmptyCollection
 */
class ResourceEmptyCollectionTest extends TestCase
{
    public function test_empty_collection_transformers_to_empty_array(): void
    {
        $emptyCollection = new EmptyCollection;
        $this->assertTrue(\is_array($emptyCollection->remodel()));
        $this->assertEmpty($emptyCollection->remodel());
    }
}