<?php

namespace Remodel\Resource;

/**
 * A resource NullCollection represents an empty collection
 * 
 * @package Remode\Resource\NullCollection
 */
class NullCollection extends Resource
{
    /**
     * @return array
     */
    public function toData()
    {
        return [];
    }
}