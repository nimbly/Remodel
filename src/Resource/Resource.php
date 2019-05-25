<?php

namespace Remodel\Resource;


use Remodel\Transformer;

/**
 * Class Resource
 * 
 * @package Remodel\Resource
 */
abstract class Resource
{
    /**
     * Data to transform.
     *
     * @var mixed
     */
    protected $data;

    /**
     * The transformer instance.
     *
     * @var Transformer
     */
    protected $transformer;

    /**
     * Convert resource into data.
     *
     * @return mixed|null
     */
    abstract public function toData();

    /**
     * Get the transformer instance.
     * 
     * @return Transformer
     */
    public function getTransformer(): ?Transformer
    {
        return $this->transformer;
    }

    /**
     * Map the includes (default and user-provided) into array indexed by top-level include referencing the nested
     * includes (if any).
     * 
     * @return array
     */
    protected function mapIncludes(array $defaultIncludes, array $userIncludes): array
    {
        $includes = array_unique(array_merge($defaultIncludes, $userIncludes));

        $mappedIncludes = [];

        // Re-work the includes, indexed by top-level referencing the nested includes
        foreach( $includes as $include ){

            // Does this include reference a nested-include
            if( ($pos = strpos($include, '.')) !== false ){
                $index = substr($include, 0, $pos);
                $nestedInclude = substr($include, $pos+1);
            } else {
                $index = $include;
                $nestedInclude = null;
            }

            // This index doesn't exist yet, create it and set it to an empty array
            if( array_key_exists($index, $mappedIncludes) === false ){
                $mappedIncludes[$index] = [];
            }

            // We have a nested include, add it to the array
            if( $nestedInclude &&
                in_array($nestedInclude, $mappedIncludes[$index]) === false ){
                $mappedIncludes[$index][] = $nestedInclude;
            }
        }

        return $mappedIncludes;
    }

    /**
     * Process all the includes defined for the transformer.
     * 
     * @param mixed $object
     * @param array $includes
     * @return array
     */
    protected function processIncludes($object, $includes): array
    {
        $data = [];

        // Process the includes
        foreach( $includes as $include => $nested ){

            $includeMethod = "{$include}Include";

            if( method_exists($this->transformer, $includeMethod) ){

                $resource = \call_user_func_array([$this->transformer, $includeMethod], [$object]);

                if( $resource === null ){
                    continue;
                }

                if( $resource instanceof static ){

                    if( $resource->transformer ){
                        $resource->transformer->setIncludes($nested);
                    }

                    $data[$include] = $resource->toData();
                }
                else {
                    $data[$include] = $resource;
                }
            }
        }

        return $data;
    }
}