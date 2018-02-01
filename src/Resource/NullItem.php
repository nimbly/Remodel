<?php

namespace Remodel\Resource;

/**
 * A resource NullItem represents an Item instance that is null
 * 
 * @package Remodel\Resource\NullItem
 */
class NullItem extends Resource
{
    /**
     * @return null
     */
    public function toData()
    {
        return null;
    }
}