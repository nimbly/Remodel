# Remodel
A simple data transformer and serializer for your API responses

## Installation

```bash
composer require nimbly/remodel
```

## Basic usage

Create a transformer that extends the ```\Remodel\Transformer``` abstract. The ```transform``` method is required and should accept
a single *thing* to transform. This *thing* could be a model object or a simple associative array or something else entirely - it really doesn't matter. Inside this method you will define and return the transformed data as an associative array.


```php
class UserTransform extends \Remodel\Transformer
{
    public function transform(User $user)
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

With our ```UserTransformer``` now defined, let's pull a user from the database, transform it, and serialize it. In order to transform the user data, we must map the data to be transformed to a specific transformer.

To do this we create a new ```Item``` resource since we are transforming a single item. If this were a collection of users, we would use the ```Collection``` resource.

```php
// Grab the user from the database
$user = User::find($id);

// Create the transformer resource
$resource = new \Remodel\Resource\Item($user, new UserTransformer);
```

To convert the resource into an API friendly response, we pass it into a serializer. **Remodel** comes with a ```JsonSerializer``` that converts a resource into a JSON string. You can create your own custom serializer by extending the ```\Remodel\Serialzier\Serializer``` abstract.

```php
// Pass transformer resource into serializer
$serializer = new \Remodel\Serializer\JsonSerializer($resource);

// Prints out JSON
echo $serializer->serialize();
```

Good job! You have now created a simple transformer that dumps out JSON. Let's dig deeper now.

## Including related data automatically
What good is a transformer if it can only transform the object you've given it? Real use cases are far more complex. What if you need to transform a book whose author is stored in a separate model instance and needs its own transformation?

Add the protected ```$includes``` array property on the transformer containing all the default includes you would like. Remodel will then look for a method of the same name as the include to do the included transformation for you.

The method should return a Resource object, a raw associative array, or null. If the method returns null, the property will **not** be included.

```php
class BookTransformer extends \Remodel\Transformer
{
    protected $includes = ['author', 'reviews'];

    public function transform(Book $book)
    {
        return [
            'id' => (int) $book->id,
            'title' => $book->title,
            'genre' => $book->genre,
            'isbn' => $book->isbn,
            'published_at' => date('c', $book->published_at),
        ];
    }

    /**
     * 
     * Remodel will call this method automatically for you since it's in the list of
     * $includes above.
     * 
     */
    public function author(Book $book)
    {
        return new \Remodel\Resource\Item($book->author, new App\Transformers\AuthorTransformer);
    }

    /**
     * 
     * Return an array of reviews
     * 
     */
    public function reviews(Book $book)
    {
        return new \Remodel\Resource\Collection($book->reviews, new App\Transformers\ReviewTransformer);
    }
}
```

Now let's create the Transformer for our Author object.

```php
class AuthorTransformer extends \Remodel\Transformer
{
    public function transform(Author $author)
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

You can nest as many includes as you'd like and to an unlimited depth.

```php
protected $includes = ['comments.user.profile'];
```

## Transforming a collection of resources

You can transform a collection of resources in a similar fashion.

```php
$collection = new \Remodel\Resource\Collection($books, new BookTransformer);
```

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

## Using a Serializer

A Transformer merely transforms your objects into a single associative array. Converting that associative array into
something more API friendly (json, xml, etc) requires a Serializer.

Remodel includes a simple JSON serializer that wraps your Resource data in a root level element called **data**. It also
provides **setMeta** and **addMeta** methods so that you may pass in additional meta data with your response. It then uses
the ```json_encode``` function to convert to JSON. The JsonSerializer implements the ```JsonSerializable``` interface.

```php
$resource = new \Remodel\Resource\Collection($users, new UserTransformer);
$response = new \Remodel\Serializer\JsonSerializer($resource);
$response->addMeta($pagination);
echo($response->serialize());
```
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


## Glossary

### Transformer
A transformer takes an object (or an associative array), transforms it into an associative array, and returns it.

### Resource
A resource maps data to a specific transformer to be applied to the data.

* **Item**
A single instance of data.

* **Collection**
A collection or set of data.

* **NullItem**
Use this resource if you would like a literal ```null``` assigned to an included resource.

* **NullCollection**
Use this resource if you would like a literal empty array ```[]``` assighed to an included resource.

### Serializer
Takes resource and serializes data into a specific format (eg, JSON or XML)