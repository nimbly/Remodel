<?php

namespace Nimbly\Remodel\Subjects;


use Nimbly\Remodel\Transformer;
use RuntimeException;

/**
 * An Item represents a single instance of something.
 *
 * @package Remodel\Subject
 */
class Item extends Subject
{
	/**
	 * Transformer instance.
	 *
	 * @var Transformer
	 */
	protected $transformer;

	/**
	 * @param mixed $data
	 * @param Transformer $transformer
	 */
	public function __construct($data, Transformer $transformer)
	{
		$this->data = $data;
		$this->transformer = $transformer;
	}

	/**
	 * @inheritDoc
	 */
	public function remodel()
	{
		if( !\method_exists($this->transformer, "transform") ){
			throw new RuntimeException("Transformer does not have a transform() method.");
		}

		$data = \call_user_func([$this->transformer, "transform"], $this->data);

		// Get needed includes
		$includes = $this->mapIncludes(
			$this->transformer->getDefaultIncludes(),
			$this->transformer->getUserIncludes()
		);

		// Process includes
		if( !empty($includes) ){
			$data = \array_merge($data, $this->processIncludes($this->data, $includes));
		}

		return $data;
	}
}