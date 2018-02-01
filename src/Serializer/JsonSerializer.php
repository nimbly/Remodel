<?php

namespace Remodel\Serializer;


use Remodel\Resource\Resource;

class JsonSerializer implements Serializer
{
    /**
     * @var Resource
     */
    protected $resource;

    protected $meta;

    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
    }

    public function serialize()
    {
        $response = ['data' => $this->resource->transform()];

        if( $this->meta ){
            $response['meta'] = $this->meta;
        }

        return json_encode($response, JSON_UNESCAPED_SLASHES);
    }

    public function setMeta($data)
    {
        $this->meta = $data;
    }

}