<?php

namespace Remodel\Serializer;


use Remodel\Resource\Resource;

/**
 * Class Json
 * @package Remodel\Serializer
 */
class Json extends Serializer
{
    /** @var mixed */
    protected $meta;

    /**
     * Serialize the resource
     * 
     * @return string
     */
    public function serialize()
    {
        $response = ['data' => $this->resource->toData()];

        if( $this->meta ){
            $response['meta'] = $this->meta;
        }

        return json_encode($response, JSON_UNESCAPED_SLASHES);
    }

    /**
     * Add meta data to the serializer
     * 
     * @param mixed $data
     * @return static
     */
    public function setMeta($data)
    {
        if( $data instanceof Resource ){
            $this->meta = $data->toData();
        }
        else {
            $this->meta = $data;
        }
        
        return $this;
    }

}