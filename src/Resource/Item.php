<?php

namespace Remodel\Resource;


use Remodel\Transformer;

/**
 * A resource Item represents a single instance of a transformed object.
 * 
 * @package Remodel\Resource
 */
class Item extends Resource
{
    /**
     * @param mixed $data
     * @param Transformer $transformer
     */
    public function __construct($data, Transformer $transformer)
    {
        $this->data = $data;
        $this->transformer = $transformer;
    }

    /**
     * @inheritDoc
     */
    public function toData()
    {
        // Transform the object
        $data = $this->transformer->transform($this->data);

        // Get needed includes
        $includes = $this->mapIncludes(
            $this->transformer->getDefaultIncludes(),
            $this->transformer->getUserIncludes()
        );

        // Process includes
        if( !empty($includes) ){
            $data = array_merge($data, $this->processIncludes($this->data, $includes));
        }

        return $data;
    }
}