<?php

namespace Remodel;

use Remodel\Resource\Collection;
use Remodel\Resource\Item;
use Remodel\Resource\NullCollection;
use Remodel\Resource\NullItem;

/**
 * Class Transformer
 * @package Remodel
 *
 * @method transform(mixed $data)
 */
abstract class Transformer
{
    /** @var array  */
    protected $includes = [];

    /** @var array  */
    protected $userIncludes = [];

    /**
     * Set user specified includes
     * 
     * @param string|array $includes
     * @return static
     */
    public function setIncludes($includes)
    {
        if( !is_array($includes) ){
            $includes = [$includes];
        }

        $this->userIncludes = $includes;

        return $this;
    }

    /**
     * Get the transformer's configured default includes
     * 
     * @return array
     */
    public function getIncludes()
    {
        return $this->includes;
    }

    /**
     * Get the user specificed includes
     * 
     * @return array
     */
    public function getUserIncludes()
    {
        return $this->userIncludes;
    }

    /**
     * Return a new Item resource instance
     * 
     * @param mixed $data
     * @param Transformer $transformer
     * @return Item
     */
    public function item($data, Transformer $transformer)
    {
        return new Item($data, $transformer);
    }

    /**
     * Return a new NullItem resource instance
     * 
     * @return NullItem
     */
    public function nullItem()
    {
        return new NullItem;
    }

    /**
     * Return a new Collection resource instance
     * 
     * @param \ArrayAccess $data
     * @param Transformer $transformer
     * @return Collection
     */
    public function collection($data, Transformer $transformer)
    {
        return new Collection($data, $transformer);
    }

    /**
     * Return a new NullCollection resource instance
     * 
     * @return NullCollection
     */
    public function nullCollection()
    {
        return new NullCollection;
    }
}