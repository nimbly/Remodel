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
    protected $defaultIncludes = [];

    /** @var array  */
    protected $userIncludes = [];

    /** @var array  */
    protected $userExcludes = [];

    /**
     * @param string|array $includes
     * @return static
     */
    public function include($includes)
    {
        if( !is_array($includes) ){
            $includes = [$includes];
        }

        $this->userIncludes = $includes;

        return $this;
    }

    /**
     * @param string|array $excludes
     * @return static
     */
    public function exclude($excludes)
    {
        if( !is_array($excludes) ){
            $excludes = [$excludes];
        }

        $this->userExcludes = $excludes;

        return $this;
    }

    /**
     * @return array
     */
    public function getDefaultIncludes()
    {
        return $this->defaultIncludes;
    }

    /**
     * @return array
     */
    public function getUserIncludes()
    {
        return $this->userIncludes;
    }

    /**
     * @return array
     */
    public function getUserExcludes(): array
    {
        return $this->userExcludes;
    }

    public function item($data, Transformer $transformer)
    {
        return new Item($data, $transformer);
    }

    public function nullItem()
    {
        return new NullItem;
    }

    public function collection($data, Transformer $transformer)
    {
        return new Collection($data, $transformer);
    }

    public function nullCollection()
    {
        return new NullCollection;
    }
}