<?php

namespace Remodel\Serializer;


use Remodel\Resource\Resource;

/**
 * Class Json
 * @package Remodel\Serializer
 */
class JsonSerializer extends Serializer implements \JsonSerializable
{
    /** @var array */
    protected $meta = [];

    /** @var string */
    protected $payloadPrefix;

    /**
     * @param Resource $resource
     * @param string $payloadPrefix
     */
    public function __construct(Resource $resource, $payloadPrefix = 'data')
    {
        parent::__construct($resource);
        $this->payloadPrefix = $payloadPrefix;
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

    /**
     * Add meta data to the serializer
     *
     * @param $key
     * @param $value
     * @return static
     */
    public function addMeta($key, $value)
    {
        if( $value instanceof Resource ){
            $this->meta[$key] = $value->toData();
        }
        else {
            $this->meta[$key] = $value;
        }

        return $this;
    }

    /**
     * Serialize the resource
     * 
     * @return string
     */
    public function serialize()
    {
        return json_encode($this->jsonSerialize(), JSON_UNESCAPED_SLASHES);
    }


    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $response = [$this->payloadPrefix => $this->resource->toData()];

        if( !empty($this->meta) ){
            $response['meta'] = $this->meta;
        }

        return $response;
    }


}