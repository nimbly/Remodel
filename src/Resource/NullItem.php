<?php

namespace Remodel\Resource;


/**
 * A resource NullItem represents an Item instance that is null
 * 
 * @package Remodel\Resource
 */
class NullItem extends Resource
{
    /**
     * @inheritDoc
     */
    public function toData()
    {
        return null;
    }
}