<?php

namespace Remodel\Tests\Transformers;

use Remodel\Transformer;

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