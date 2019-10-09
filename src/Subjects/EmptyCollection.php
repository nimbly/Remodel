<?php

namespace Remodel\Subjects;


/**
 * An EmptyCollection Subject represents an empty array.
 * 
 * @package Remode\Subject
 */
class EmptyCollection extends Subject
{
    /**
     * @inheritDoc
     */
    public function remodel()
    {
        return [];
    }
}