<?php

namespace Remodel\Resource;


/**
 * A resource EmptyCollection represents an empty array.
 * 
 * @package Remode\Resource
 */
class EmptyCollection extends Resource
{
    /**
     * @inheritDoc
     */
    public function toData()
    {
        return [];
    }
}