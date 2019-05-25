<?php

namespace Remodel;

use Remodel\Resource\Collection;
use Remodel\Resource\EmptyObject;
use Remodel\Resource\Item;
use Remodel\Resource\EmptyCollection;
use Remodel\Resource\NullItem;

/**
 * Class Transformer
 * @package Remodel
 * 
 * @method array transform(mixed $object)
 */
abstract class Transformer
{
    /**
     * Default includes.
     *
     * @var array
     */
    protected $defaultIncludes = [];

    /**
     * User provided includes.
     *
     * @var array
     */
    protected $userIncludes = [];

    /**
     * Set user specified includes.
     * 
     * @param string|array $includes
     * @return Transformer
     */
    public function setIncludes($includes): Transformer
    {
        if( !is_array($includes) ){
            $includes = array_map('trim', explode(',', $includes));
        }

        $this->userIncludes = $includes;

        return $this;
    }

    /**
     * Get the transformer's configured default includes.
     * 
     * @return array
     */
    public function getDefaultIncludes(): array
    {
        return $this->defaultIncludes;
    }

    /**
     * Get the user specificed includes.
     * 
     * @return array
     */
    public function getUserIncludes(): array
    {
        return $this->userIncludes;
    }

    /**
     * Return a new Item resource instance.
     * 
     * @param mixed $data
     * @param Transformer $transformer
     * @return Item
     */
    public function item($data, Transformer $transformer): Item
    {
        return new Item($data, $transformer);
    }

    /**
     * Return a new NullItem resource instance.
     * 
     * @return NullItem
     */
    public function nullItem(): NullItem
    {
        return new NullItem;
    }

    /**
     * Return a new Collection resource instance.
     * 
     * @param \Traversable|array $data
     * @param Transformer $transformer
     * @return Collection
     */
    public function collection($data, Transformer $transformer): Collection
    {
        return new Collection($data, $transformer);
    }

    public function emptyObject(): EmptyObject
    {
        return new EmptyObject;
    }

    /**
     * Return a new NullCollection resource instance.
     * 
     * @return NullCollection
     */
    public function emptyCollection(): EmptyCollection
    {
        return new EmptyCollection;
    }
}