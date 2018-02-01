# Remodel
Simple JSON data transformer for your API responses

## Installation

```bash
composer require nimbly/remodel
```

## Basic usage

Create a transformer for a model that extends the ```Remodel\Transformer``` abstract.

```php
class UserTransform extends Remodel\Transformer
{
    public function transform(App\Models\User $user)
    {
        return [
            'id' => (int) $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => date('c', $user->created_at),
        ];
    }
}
```
##

Create a resource for the object being transformed.

A single instance will use ```Remodel\Resource\Item``` and a collection of instances will use the ```Remodel\Resource\Collection```.

Transform a user object into a JSON response.

```php
$user = App\Models\User::find($id);
$resource = new Remodel\Resource\Item($user, new UserTransformer);
$response = new Remodel\Serializer\JsonSerializer($resource);
```

```php
echo($response->serialize());
```

Will produce

```json
{
    "id": 345678,
    "name": "John Doe",
    "email": "jdoe@example.com",
    "created_at": "2018-01-31 14:52:09-08:00"
}
```

## Including related data
What good is a transformer if it only transforms the object you've given it? What if you need to transform a set of books whose author is stored in a separate model?

Let's create a transformer for the Author object.

```php
class AuthorTransformer extends Remodel\Transformer
{
    public function transform(App\Models\Author $author)
    {
        return [
            'id' => (int) $author->id,
            'name' => $author->name,
        ];
    }
}
```

Now, let's create the transformer for a Book object that includes an Author object.

```php
class BookTransformer extends Remodel\Transformer
{
    protected $defaultIncludes = ['author'];

    public function transform(App\Models\Book $book)
    {
        return [
            'id' => (int) $book->id,
            'title' => $book->title,
            'genre' => $book->genre,
            'isbn' => $book->isbn,
            'published_at' => date('c', $book->published_at),
        ];
    }

    public function includeAuthor(App\Models\Book $book)
    {
        return new Remodel\Resource\Item($book->author, new App\Transformers\AuthorTransformer);
    }
}
```