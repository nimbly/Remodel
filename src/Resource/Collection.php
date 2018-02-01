<?php

namespace Remode\Resource;


use Remodel\Transformer;

class Collection extends Resource
{
    public function __construct(\ArrayAccess $data, Transformer $transformer)
    {
        $this->data = $data;
        $this->transformer = $transformer;
    }

    public function transform()
    {
        $transformedData = [];

        foreach( $this->data as $data )
        {
            $transformedData[] = (new Item($data, $this->transformer))->transform();
        }

        return $transformedData;
    }
}
