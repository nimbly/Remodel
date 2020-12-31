<?php

namespace Nimbly\Remodel\Subjects;


use Nimbly\Remodel\Transformer;

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
		// Transform the object
		if( \method_exists($this->transformer, "transform") ){
			$data = \call_user_func([$this->transformer, "transform"], $this->data);
		}
		else {
			return null;
		}

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