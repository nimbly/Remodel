<?php

namespace Remodel\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Remodel\Subjects\Collection;
use Remodel\Subjects\EmptyCollection;
use Remodel\Subjects\EmptyObject;
use Remodel\Subjects\Item;
use Remodel\Subjects\NullItem;
use Remodel\Tests\Transformers\AuthorTransformer;
use Remodel\Tests\Transformers\BookTransformer;
use Remodel\Tests\Transformers\CommentTransformer;

/**
 * @covers Remodel\Transformer
 * @covers Remodel\Subjects\Item
 * @covers Remodel\Subjects\NullItem
 * @covers Remodel\Subjects\Collection
 * @covers Remodel\Subjects\EmptyCollection
 * @covers Remodel\Subjects\EmptyObject
 */
class TransformerTest extends TestCase
{
    private function getBook(): object
    {
        return (object) [
            'id' => 12345,
            'isbn' => "0-345-30129-3",
            'title' => "Do Androids Dream of Electric Sheep",
            'published_at' => '1982-05-01',
            'author' => (object) [
                'id' => 5678,
                'name' => 'Phillip K. Dick',
                'bio' => 'Lorem ipsum'
            ],
            'comments' => [
                (object) [
                    'id' => 45,
                    'title' => 'Fantastic read!',
                    'description' => 'Best book I\'ve read in a long time!',
                    'rating' => 8
                ],

                (object) [
                    'id' => 45,
                    'title' => 'Sci-Fi classic',
                    'description' => 'If you haven\'t read this classic novel, you\'re doing yourself a great disservice.',
                    'rating' => 9
                ]
            ]
        ];
    }

    public function test_add_includes_accepts_string()
    {
        $transformer = new BookTransformer;
        $transformer->addIncludes('comments');

        $reflectionClass = new ReflectionClass($transformer);
        $property = $reflectionClass->getProperty('userIncludes');
        $property->setAccessible(true);

        $this->assertEquals([
            'comments'
        ], $property->getValue($transformer));
    }

    public function test_add_includes_accepts_array()
    {
        $transformer = new BookTransformer;
        $transformer->addIncludes(['comments', 'author']);

        $reflectionClass = new ReflectionClass($transformer);
        $property = $reflectionClass->getProperty('userIncludes');
        $property->setAccessible(true);

        $this->assertEquals([
            'comments', 'author'
        ], $property->getValue($transformer));
    }

    public function test_get_default_includes()
    {
        $transformer = new BookTransformer;

        $this->assertEquals([
            'author'
        ], $transformer->getDefaultIncludes());
    }

    public function test_get_user_includes()
    {
        $transformer = new BookTransformer;
        $transformer->addIncludes('comments');

        $this->assertEquals([
            'comments'
        ], $transformer->getUserIncludes());
    }

    public function test_item_returns_instance()
    {
        $book = $this->getBook();
        $transformer = new BookTransformer;
        
        $this->assertInstanceOf(
            Item::class,
            $transformer->item($book->author, new AuthorTransformer)
        );
    }

    public function test_null_item_returns_instance()
    {
        $transformer = new BookTransformer;
        $this->assertInstanceOf(
            NullItem::class,
            $transformer->nullItem()
        );
    }

    public function test_collection_returns_instance()
    {
        $book = $this->getBook();
        $transformer = new BookTransformer;
        
        $this->assertInstanceOf(
            Collection::class,
            $transformer->collection($book->comments, new CommentTransformer)
        );
    }

    public function test_empty_collection_returns_instance()
    {
        $transformer = new BookTransformer;
        $this->assertInstanceOf(
            EmptyCollection::class,
            $transformer->emptyCollection()
        );
    }

    public function test_empty_object_returns_instance()
    {
        $transformer = new BookTransformer;
        $this->assertInstanceOf(
            EmptyObject::class,
            $transformer->emptyObject()
        );
    }
}