<?php

namespace Remodel\Tests;

use PHPUnit\Framework\TestCase;
use Remodel\Subjects\EmptyObject;

/**
 * @covers Remodel\Subjects\EmptyObject
 */
class SubjectEmptyObjectTest extends TestCase
{
    public function test_empty_object_transformers_to_a_stdclass()
    {
        $emptyObject = new EmptyObject;
        $this->assertTrue(\is_object($emptyObject->remodel()));
        $this->assertEmpty(\get_object_vars($emptyObject));
    }
}