<?php

namespace Remodel\Serializer;

use Remodel\Resource\Resource;

/**
 * Abstract Serializer
 * 
 * @package Remodel\Serializer
 */
abstract class Serializer
{
    /** @var Resource */
    protected $resource;

    /**
     * @param Resource $resource
     */
    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
    }

    /**
     * Serialize the resouce instance
     * 
     * @return string
     */
    abstract public function serialize();
}