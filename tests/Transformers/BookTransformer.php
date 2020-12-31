<?php

namespace Nimbly\Remodel\Tests\Transformers;

use Nimbly\Remodel\Subjects\Collection;
use Nimbly\Remodel\Subjects\Item;
use Nimbly\Remodel\Transformer;


class BookTransformer extends Transformer
{
    protected $defaultIncludes = ["author"];

    public function transform(object $book): array
    {
        return [
            "id" => $book->id,
            "title" => $book->title,
            "description" => $book->description,
            "isbn" => $book->isbn
        ];
    }

    public function authorInclude(object $book): Item
    {
        return $this->item($book->author, new AuthorTransformer);
    }

    public function commentsInclude(object $book): Collection
    {
        return $this->collection($book->comments, new CommentTransformer);
    }
}