<?php

namespace Remodel\Subjects;


/**
 * A NullItem represents an Item instance that is null
 * 
 * @package Remodel\Subject
 */
class NullItem extends Subject
{
    /**
     * @inheritDoc
     */
    public function remodel()
    {
        return null;
    }
}