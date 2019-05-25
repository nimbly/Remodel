<?php

namespace Remodel\Tests;

use PHPUnit\Framework\TestCase;
use Remodel\CallableTransformer;
use Remodel\Resource\Item;
use Remodel\Transformer;

/**
 * @covers Remodel\Resource\Resource
 * @covers Remodel\Resource\Item
 * @covers Remodel\CallableTransformer
 * @covers Remodel\Transformer
 */
class ResourceResourceTest extends TestCase
{
    public function test_resource_abstract_get_transformer()
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

        $this->assertTrue($item->getTransformer() instanceof Transformer);
    }
}