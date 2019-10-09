<?php

namespace Remodel\Tests;

use PHPUnit\Framework\TestCase;
use Remodel\CallableTransformer;
use Remodel\Subjects\Item;

/**
 * @covers Remodel\Subjects\Item
 * @covers Remodel\CallableTransformer
 * @covers Remodel\Transformer
 * @covers Remodel\Subjects\Subject
 */
class SubjectItemTest extends TestCase
{
    public function test_resource_item_transforms_to_single_array()
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