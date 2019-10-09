<?php

namespace Remodel\Subjects;


/**
 * An EmptyObject represents an empty object.
 * 
 * @package Remode\Subject
 */
class EmptyObject extends Subject
{
    /**
     * @inheritDoc
     */
    public function remodel()
    {
        return new \stdClass;
    }
}