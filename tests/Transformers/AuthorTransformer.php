<?php

namespace Remodel\Tests\Transformers;

use Remodel\Transformer;

class AuthorTransformer extends Transformer
{
    public function transform(object $author): array
    {
        return [
            'id' => $author->id,
            'name' => $author->name,
            'bio' => $author->bio
        ];
    }
}