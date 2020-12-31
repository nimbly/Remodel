<?php

namespace Nimbly\Remodel\Tests;

use PHPUnit\Framework\TestCase;
use Nimbly\Remodel\CallableTransformer;
use Nimbly\Remodel\Subjects\Item;

/**
 * @covers Nimbly\Remodel\Subjects\Item
 * @covers Nimbly\Remodel\CallableTransformer
 * @covers Nimbly\Remodel\Transformer
 * @covers Nimbly\Remodel\Subjects\Subject
 */
class SubjectItemTest extends TestCase
{
    public function test_resource_item_transforms_to_single_array(): void
    {
        $data = (object) [
            "id" => 1,
            "name" => "John Doe",
            "password" => '$2y$10$EfIqopgVNY8Bdw/GiIAOl.PVMyERHG5zfE0fYh9FtWvmECS1ZWIdu',
        ];

        $item = new Item(
            $data,
            new CallableTransformer(function(object $data){

                return [
                    "id" => $data->id,
                    "name" => $data->name,
                ];

            })
        );

        $this->assertEquals(
            [
                "id" => 1,
                "name" => "John Doe"
            ],
            $item->remodel()
        );
    }
}