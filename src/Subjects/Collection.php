<?php

namespace Nimbly\Remodel\Subjects;

use Nimbly\Remodel\Transformer;
use Traversable;

/**
 * A Collection represents a collection or set of subject Items.
 *
 * @package Remodel\Subject
 */
class Collection extends Subject
{
	/**
	 * Transformer instance.
	 *
	 * @var Transformer
	 */
	protected $transformer;

	/**
	 * @param Traversable|iterable|array $data
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
		$transformedData = [];

		foreach( $this->data as $subject ){

			if( \method_exists($this->transformer, "transform") ){
				$data = \call_user_func([$this->transformer, "transform"], $subject);
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
