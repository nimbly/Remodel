<?php

namespace Nimbly\Remodel;

use Nimbly\Remodel\Subjects\Collection;
use Nimbly\Remodel\Subjects\EmptyCollection;
use Nimbly\Remodel\Subjects\EmptyObject;
use Nimbly\Remodel\Subjects\Item;
use Nimbly\Remodel\Subjects\NullItem;
use Traversable;

/**
 * Class Transformer
 * @package Remodel
 *
 * @method transform($thing): array
 */
abstract class Transformer
{
	/**
	 * Default includes.
	 *
	 * @var array
	 */
	protected $defaultIncludes = [];

	/**
	 * User provided includes.
	 *
	 * @var array
	 */
	protected $userIncludes = [];

	/**
	 * Set user specified includes.
	 *
	 * @param string|array $includes
	 * @return Transformer
	 */
	public function setIncludes($includes): Transformer
	{
		if( !\is_array($includes) ){
			$includes = \array_map("trim", \explode(",", $includes));
		}

		$this->userIncludes = $includes;

		return $this;
	}

	/**
	 * Set the transformer's default includes.
	 *
	 * @param array $includes
	 * @return void
	 */
	public function setDefaultIncludes(array $includes): void
	{
		$this->defaultIncludes = $includes;
	}

	/**
	 * Get the transformer's configured default includes.
	 *
	 * @return array
	 */
	public function getDefaultIncludes(): array
	{
		return $this->defaultIncludes;
	}

	/**
	 * Get the user specificed includes.
	 *
	 * @return array
	 */
	public function getUserIncludes(): array
	{
		return $this->userIncludes;
	}

	/**
	 * Return a new Item subject instance.
	 *
	 * @param mixed $data
	 * @param Transformer $transformer
	 * @return Item
	 */
	public function item($data, Transformer $transformer): Item
	{
		return new Item($data, $transformer);
	}

	/**
	 * Return a new NullItem subject instance.
	 *
	 * @return NullItem
	 */
	public function nullItem(): NullItem
	{
		return new NullItem;
	}

	/**
	 * Return a new Collection subject instance.
	 *
	 * @param Traversable|iterable|array $data
	 * @param Transformer $transformer
	 * @return Collection
	 */
	public function collection($data, Transformer $transformer): Collection
	{
		return new Collection($data, $transformer);
	}

	/**
	 * Return a new empty object instance.
	 *
	 * @return EmptyObject
	 */
	public function emptyObject(): EmptyObject
	{
		return new EmptyObject;
	}

	/**
	 * Return a new EmptyCollection subject instance.
	 *
	 * @return EmptyCollection
	 */
	public function emptyCollection(): EmptyCollection
	{
		return new EmptyCollection;
	}
}