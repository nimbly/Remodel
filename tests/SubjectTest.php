<?php

namespace Nimbly\Remodel\Tests;

use PHPUnit\Framework\TestCase;
use Nimbly\Remodel\CallableTransformer;
use Nimbly\Remodel\Subjects\Item;
use Nimbly\Remodel\Transformer;

/**
 * @covers Nimbly\Remodel\Subjects\Subject
 * @covers Nimbly\Remodel\Subjects\Item
 * @covers Nimbly\Remodel\CallableTransformer
 * @covers Nimbly\Remodel\Transformer
 */
class SubjectTest extends TestCase
{
    public function test_subject_abstract_get_transformer(): void
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