<?php

namespace Nimbly\Remodel\Tests;

use PHPUnit\Framework\TestCase;
use Nimbly\Remodel\CallableTransformer;
use Nimbly\Remodel\Subjects\Collection;

/**
 * @covers Nimbly\Remodel\Subjects\Collection
 * @covers Nimbly\Remodel\Subjects\Item
 * @covers Nimbly\Remodel\Subjects\Subject
 * @covers Nimbly\Remodel\CallableTransformer
 * @covers Nimbly\Remodel\Transformer
 */
class CollectionResourceTest extends TestCase
{
    public function test_collection_transforms_to_set_of_arrays(): void
    {
        $data = [
            [
                "id" => 1,
                "name" => "John Doe",
                "password" => '$2y$10$EfIqopgVNY8Bdw/GiIAOl.PVMyERHG5zfE0fYh9FtWvmECS1ZWIdu',
            ],

            [
                "id" => 2,
                "name" => "Jane Doe",
                "password" => '$2y$10$uL1uq20Z/EJv8J9YmWmfDe7aSsuf.59XSKpL/k9Dr6vTIaehzmzd6',
            ]
        ];

        $collection = new Collection(
            $data,
            new CallableTransformer(function($data){

                return [
                    "id" => $data['id'],
                    "name" => $data['name'],
                ];

            })
        );

        $this->assertTrue(\is_array($collection->remodel()));
        $this->assertTrue(\is_array($collection->remodel()[0]));
    }
}