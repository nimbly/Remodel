<?php

namespace Remodel\Resource;


use Remodel\Transformer;

abstract class Resource
{
    /** @var mixed */
    protected $data;

    /** @var Transformer */
    protected $transformer;

    /**
     * @return mixed
     */
    abstract public function toData();
}