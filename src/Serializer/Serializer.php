<?php

namespace Remodel\Serializer;

/**
 * Abstract Serliazer
 * 
 * @package Remodel\Serializer\Serializer
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