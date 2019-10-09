<?php

namespace Remodel\Subjects;


use Remodel\Transformer;
use Traversable;

/**
 * A Collection represents a collection or set of subject Items.
 * 
 * @package Remodel\Subject
 */
class Collection extends Subject
{
    /**
     * @param Traversable|array $data
     * @param Transformer $transformer
     */
    public function __construct($data, Transformer $transformer)
    {
        $this->data = $data;
        $this->transformer = $transformer;
    }

    public function remodel()
    {
        $transformedData = [];

        foreach( $this->data as $subject ){

            // Transform the object
            if( \method_exists($this->transformer, 'transform') ){
                /**
                 * @psalm-suppress InvalidArgument
                 */
                $data = \call_user_func([$this->transformer, 'transform'], $subject);
            }
            else {
                continue;
            }

            // Get needed includes
            $includes = $this->mapIncludes(
                $this->transformer->getDefaultIncludes(),
                $this->transformer->getUserIncludes()
            );

            // Process includes
            if( !empty($includes) ){
                $data = \array_merge($data, $this->processIncludes($subject, $includes));
            }

            $transformedData[] = $data;
        }

        return $transformedData;
    }
}
