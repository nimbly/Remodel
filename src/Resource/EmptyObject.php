<?php

namespace Remodel\Resource;



class EmptyObject extends Resource
{
    /**
     * @inheritDoc
     */
    public function toData()
    {
        return new \StdClass;
    }
}