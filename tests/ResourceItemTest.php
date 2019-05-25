<?php

namespace Remodel\Tests;

use PHPUnit\Framework\TestCase;
use Remodel\CallableTransformer;
use Remodel\Resource\Item;

/**
 * @covers Remodel\Resource\Item
 * @covers Remodel\CallableTransformer
 * @covers Remodel\Transformer
 * @covers Remodel\Resource\Resource
 */
class ResourceItemTest extends TestCase
{
    public function test_resource_item_transforms_to_single_array()
    {
        $data = [
            "id" => 1,
            "name" => "John Doe",
            "password" => '$2y$10$EfIqopgVNY8Bdw/GiIAOl.PVMyERHG5zfE0fYh9FtWvmECS1ZWIdu',
        ];

        $item = new Item(
            $data,
            new CallableTransformer(function($data){

                return [
                    "id" => $data['id'],
                    "name" => $data['name'],
                ];

            })
        );

        $this->assertTrue(is_array($item->toData()));
    }
}