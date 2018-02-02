<?php

namespace Remodel\Resource;


use Remodel\Transformer;

/**
 * Class Resource
 * @package Remodel\Resource
 */
abstract class Resource
{
    /** @var mixed */
    protected $data;

    /** @var Transformer */
    protected $transformer;

    /**
     * Convert resource into data array
     *
     * @return mixed
     */
    abstract public function toData();

    /**
     * @return Transformer
     */
    public function getTransformer()
    {
        return $this->transformer;
    }
}