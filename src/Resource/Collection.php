<?php

namespace Remodel\Resource;


use Remodel\Transformer;

/**
 * A resource Collection represents a collection or set of resource Items.
 * 
 * @package Remodel\Resource
 */
class Collection extends Resource
{
    /**
     * @param \ArrayAccess $data
     * @param Transformer $transformer
     */
    public function __construct(\ArrayAccess $data, Transformer $transformer)
    {
        $this->data = $data;
        $this->transformer = $transformer;
    }

    /**
     * Convert the resource into an array of data
     * 
     * @return array
     */
    public function toData()
    {
        $transformedData = [];

        foreach( $this->data as $data ){
            $transformedData[] = (new Item($data, $this->transformer))->toData();
        }

        return $transformedData;
    }
}
