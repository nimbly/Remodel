# Remodel
Simple data transformer and serializer for your API responses

## Installation

```bash
composer require nimbly/remodel
```

## Basic usage

Create a transformer for a model that extends the ```Remodel\Transformer``` abstract.

```php
class UserTransform extends \Remodel\Transformer
{
    public function transform(\App\Models\User $user)
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
$resource = new \Remodel\Resource\Item($user, new UserTransformer);
$response = new \Remodel\Serializer\Json($resource);
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

## Including related data automatically
What good is a transformer if it can only transform the object you've given it? What if you need to transform a book whose author is stored in a separate model instance and needs its own transformation.

Add the ```$includes``` array property on the transformer containing
all the default includes you would like.

Remodel will then look for a method of the same name as the
include to do the included transformation for you.

```php
class BookTransformer extends \Remodel\Transformer
{
    protected $includes = ['author'];

    public function transform(\App\Models\Book $book)
    {
        return [
            'id' => (int) $book->id,
            'title' => $book->title,
            'genre' => $book->genre,
            'isbn' => $book->isbn,
            'published_at' => date('c', $book->published_at),
        ];
    }

    public function author(App\Models\Book $book)
    {
        return new \Remodel\Resource\Item($book->author, new App\Transformers\AuthorTransformer);
    }
}
```


Now let's create the Transformer for our Author object.

```php
class AuthorTransformer extends \Remodel\Transformer
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

## Nested includes
What if you need an optional include on another include? For example, if the Author also has an Address object that is not included by default?

You can nest includes by using a dot notation.

```php
protected $includes = ['author.address'];
```
This will include an Author and its Address object.

You can nest as many includes as you'd like.

```php
protected $includes = ['comments.user.profile'];
```

## Transforming a collection of resources

You can transform a collection of resources in a similar fashion.

```php
$books = \App\Models\Book::all();
$collection = new \Remodel\Resource\Collection($books, new BookTransformer);
```

You can then pass the Collection resource off to the Serializer and it will handle the rest.

## Adding includes at run time
What if you don't always need a related resource included with every transformation? Maybe it's a resource
provided only when the requesting client needs it?

You can pass run-time user supplied includes into the Transformer instance.

```php
$transformer = new BookTransformer;
$transformer->setIncludes(['author', 'publisher']);

// OR

$transformer = (new BookTransformer)->setIncludes(['author', 'publisher']);
```

## Using the Serializer

A Transformer merely transforms your objects into a single associative array. Converting that associative array into
something more API friendly (json, xml, etc) requires a Serializer.

Remodel includes a simple JSON serializer that wraps your Resource data in a root level element called **data**. It also
provides a **setMeta** method so that you may pass in additional meta data with your response. It then uses the ```json_encode``` function to convert to JSON.

For example
```json
{
    "data": [
        {
            "id": 123456,
            "name": "Joe Biden",
            "email": "joe@example.com"
        },

        {
            "id": 123414,
            "name": "Sarah Silverman",
            "email": "sarah@example.com"
        }
    ],

    "meta": {
        "page":  1,
        "total": 14,
        "next": 2,
        "previous": null
    }
}
```

## Extending the Serializer
Create your own custom Serializer by extending ```Remodel\Serializer\Serializer``` abstract.