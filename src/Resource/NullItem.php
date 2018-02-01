<?php

namespace Remodel\Resource;


class NullItem extends Resource
{
    public function transform()
    {
        return null;
    }
}