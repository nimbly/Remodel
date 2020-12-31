<?php

namespace Nimbly\Remodel\Tests\Transformers;

use Nimbly\Remodel\Transformer;

class CommentTransformer extends Transformer
{
    public function transform(object $comment): array
    {
        return [
            'id' => $comment->id,
            'title' => $comment->title,
            'description' => $comment->description,
            'rating' => $comment->rating
        ];
    }
}