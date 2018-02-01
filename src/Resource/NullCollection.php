<?php

namespace Remodel\Resource;


class NullCollection extends Resource
{
    public function transform()
    {
        return [];
    }
}