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
     * @param \Traversable|array $data
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
        $transformedData = [];
        foreach( $this->data as $data ){
            $transformedData[] = (new Item($data, $this->transformer))->toData();
        }

        return $transformedData;
    }

    public function toData2()
    {
        $transformedData = [];

        foreach( $this->data as $object ){

            // Transform the object
            $data = $this->transformer->transform($object);

            // Get needed includes
            $includes = $this->mapIncludes(
                $this->transformer->getDefaultIncludes(),
                $this->transformer->getUserIncludes()
            );

            // Process includes
            if( !empty($includes) ){
                $data = \array_merge($data, $this->processIncludes($object, $includes));
            }

            $transformedData[] = $data;
        }

        return $transformedData;
    }
}
