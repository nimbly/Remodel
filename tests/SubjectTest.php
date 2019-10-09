<?php

namespace Remodel\Tests;

use PHPUnit\Framework\TestCase;
use Remodel\CallableTransformer;
use Remodel\Subjects\Item;
use Remodel\Transformer;

/**
 * @covers Remodel\Subjects\Subject
 * @covers Remodel\Subjects\Item
 * @covers Remodel\CallableTransformer
 * @covers Remodel\Transformer
 */
class SubjectTest extends TestCase
{
    public function test_subject_abstract_get_transformer()
    {
        $item = new Item(
            [
                "id" => 1,
                "name" => "John Doe",
            ],
            new CallableTransformer(function($data){

                return [
                    "id" => 1,
                    "name" => "John Doe",
                ];

            })
        );

        $this->assertInstanceOf(
            Transformer::class,
            $item->getTransformer()
        );
    }
}