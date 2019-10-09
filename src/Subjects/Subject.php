<?php

namespace Remodel\Subjects;


use Remodel\Transformer;

/**
 * Class Subject
 * 
 * @package Remodel\Subject
 */
abstract class Subject
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
     * Remodel subject(s) into desired output.
     *
     * @return mixed|null
     */
    abstract public function remodel();

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
     * @param array<string> $defaultIncludes
     * @param array<string> $userIncludes
     * @return array<string, array<string>>
     */
    protected function mapIncludes(array $defaultIncludes, array $userIncludes): array
    {
        $includes = \array_unique(\array_merge($defaultIncludes, $userIncludes));

        $mappedIncludes = [];

        // Re-work the includes, indexed by top-level referencing the nested includes
        foreach( $includes as $include ){

            // Does this include reference a nested-include
            if( ($pos = \strpos($include, '.')) !== false ){
                $index = \substr($include, 0, $pos);
                $nestedInclude = \substr($include, $pos+1);
            } else {
                $index = $include;
                $nestedInclude = null;
            }

            // This index doesn't exist yet, create it and set it to an empty array
            if( \array_key_exists($index, $mappedIncludes) === false ){
                $mappedIncludes[$index] = [];
            }

            // We have a nested include, add it to the array
            if( $nestedInclude &&
                \in_array($nestedInclude, $mappedIncludes[$index]) === false ){
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

            if( \method_exists($this->transformer, $includeMethod) ){

                $subject = \call_user_func([$this->transformer, $includeMethod], $object);

                if( $subject === null ){
                    continue;
                }

                if( $subject instanceof static ){

                    if( $subject->transformer ){
                        $subject->transformer->setIncludes($nested);
                    }

                    $data[$include] = $subject->remodel();
                }
                else {
                    $data[$include] = $subject;
                }
            }
        }

        return $data;
    }
}