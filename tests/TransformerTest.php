<?php

namespace Nimbly\Remodel\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Nimbly\Remodel\Subjects\Collection;
use Nimbly\Remodel\Subjects\EmptyCollection;
use Nimbly\Remodel\Subjects\EmptyObject;
use Nimbly\Remodel\Subjects\Item;
use Nimbly\Remodel\Subjects\NullItem;
use Nimbly\Remodel\Tests\Transformers\AuthorTransformer;
use Nimbly\Remodel\Tests\Transformers\BookTransformer;
use Nimbly\Remodel\Tests\Transformers\CommentTransformer;

/**
 * @covers Nimbly\Remodel\Transformer
 * @covers Nimbly\Remodel\Subjects\Item
 * @covers Nimbly\Remodel\Subjects\NullItem
 * @covers Nimbly\Remodel\Subjects\Collection
 * @covers Nimbly\Remodel\Subjects\EmptyCollection
 * @covers Nimbly\Remodel\Subjects\EmptyObject
 * @covers Nimbly\Remodel\Subjects\Subject
 */
class TransformerTest extends TestCase
{
	private function getBook(): object
	{
		return (object) [
			"id" => 12345,
			"isbn" => "0-345-30129-3",
			"title" => "Do Androids Dream of Electric Sheep",
			"published_at" => "1982-05-01",
			"author" => (object) [
				"id" => 5678,
				"name" => "Phillip K. Dick",
				"bio" => "Lorem ipsum"
			],
			"comments" => [
				(object) [
					"id" => 45,
					"title" => "Fantastic read!",
					"description" => "Best book I\"ve read in a long time!",
					"rating" => 8
				],

				(object) [
					"id" => 45,
					"title" => "Sci-Fi classic",
					"description" => "If you haven\"t read this classic novel, you\"re doing yourself a great disservice.",
					"rating" => 9
				]
			]
		];
	}

	public function test_set_includes_accepts_string(): void
	{
		$transformer = new BookTransformer;
		$transformer->setIncludes("comments");

		$reflectionClass = new ReflectionClass($transformer);
		$property = $reflectionClass->getProperty("userIncludes");
		$property->setAccessible(true);

		$this->assertEquals([
			"comments"
		], $property->getValue($transformer));
	}

	public function test_set_includes_accepts_array(): void
	{
		$transformer = new BookTransformer;
		$transformer->setIncludes(["comments", "author"]);

		$reflectionClass = new ReflectionClass($transformer);
		$property = $reflectionClass->getProperty("userIncludes");
		$property->setAccessible(true);

		$this->assertEquals([
			"comments", "author"
		], $property->getValue($transformer));
	}

	public function test_get_default_includes(): void
	{
		$transformer = new BookTransformer;

		$this->assertEquals([
			"author"
		], $transformer->getDefaultIncludes());
	}

	public function test_get_user_includes(): void
	{
		$transformer = new BookTransformer;
		$transformer->setIncludes("comments");

		$this->assertEquals([
			"comments"
		], $transformer->getUserIncludes());
	}

	public function test_item_returns_instance(): void
	{
		$book = $this->getBook();
		$transformer = new BookTransformer;

		$this->assertInstanceOf(
			Item::class,
			$transformer->item($book->author, new AuthorTransformer)
		);
	}

	public function test_null_item_returns_instance(): void
	{
		$transformer = new BookTransformer;
		$this->assertInstanceOf(
			NullItem::class,
			$transformer->nullItem()
		);
	}

	public function test_collection_returns_instance(): void
	{
		$book = $this->getBook();
		$transformer = new BookTransformer;

		$this->assertInstanceOf(
			Collection::class,
			$transformer->collection($book->comments, new CommentTransformer)
		);
	}

	public function test_empty_collection_returns_instance(): void
	{
		$transformer = new BookTransformer;
		$this->assertInstanceOf(
			EmptyCollection::class,
			$transformer->emptyCollection()
		);
	}

	public function test_empty_object_returns_instance(): void
	{
		$transformer = new BookTransformer;
		$this->assertInstanceOf(
			EmptyObject::class,
			$transformer->emptyObject()
		);
	}
}