<?php

namespace Remodel\Tests;

use PHPUnit\Framework\TestCase;
use Remodel\Resource\EmptyObject;

/**
 * @covers Remodel\Resource\EmptyObject
 */
class ResourceEmptyObjectTest extends TestCase
{
    public function test_empty_object_transformers_to_a_stdclass()
    {
        $emptyObject = new EmptyObject;
        $this->assertTrue(\is_object($emptyObject->toData()));
        $this->assertEmpty(\get_object_vars($emptyObject));
    }
}