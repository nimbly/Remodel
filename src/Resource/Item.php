<?php

namespace Remodel\Resource;


use Remodel\Transformer;

class Item extends Resource
{
    public function __construct($data, Transformer $transformer)
    {
        $this->data = $data;
        $this->transformer = $transformer;
    }

    public function transform()
    {
        $data = $this->transformer->transform($this->data);
        $includes = array_unique(array_merge($this->transformer->getDefaultIncludes(), $this->transformer->getUserIncludes()));

        if( !empty($includes) ){

            $filteredIncludes = [];

            // Find nested includes and group them all together based on the top-level include
            foreach( $includes as $include ){

                // Gather up nested includes
                if( ($pos = strpos($include, '.')) !== false ){
                    $index = substr($include, 0, $pos);
                    $nestedInclude = substr($include, $pos+1);
                } else {
                    $index = $include;
                    $nestedInclude = null;
                }

                if( !isset($filteredIncludes[$index]) ){
                    $filteredIncludes[$index] = [];
                }

                if( $nestedInclude &&
                    !in_array($nestedInclude, $filteredIncludes[$index]) ){
                    $filteredIncludes[$index][] = $nestedInclude;
                }
            }

            foreach( $filteredIncludes as $include => $nested ){

                $method = "include" . ucfirst($include);
                if( method_exists($this->transformer, $method) ){

                    $resource = $this->transformer->{$method}($this->data);

                    if( $resource === null ){
                        continue;
                    }

                    if( $resource instanceof Resource ){

                        // Is this a Resource with a transformer (i.e. Item or Collection?)
                        if( $resource->transformer ){
                            $resource->transformer->include($nested);
                        }

                        $data[$include] = $resource->transform();
                    }
                    else {
                        $data[$include] = $resource;
                    }
                }
            }
        }

        return $data;
    }
}