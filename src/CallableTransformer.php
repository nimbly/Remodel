<?php

namespace Remodel;

/**
 * @package Remodel
 * 
 * The CallableTransformer allows you to pass in a closure or other callable to transform your data.
 * 
 */
class CallableTransformer extends Transformer
{
    /**
     * The callable to use to transform the data.
     *
     * @var callable
     */
    protected $callable;

    /**
     * CallableTransformer constructor.
     *
     * @param callable $callable
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * Transform the data.
     *
     * @param mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return \call_user_func($this->callable, $data);
    }
}