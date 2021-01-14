# Remodel
A simple data transformer for your API responses.

## Installation

```bash
composer require nimbly/remodel
```

## Basic usage

Create a transformer that extends the `Nimbly\Remodel\Transformer` abstract. The `transform` method is required and should accept
a single *thing* to transform. This *thing* could be a model object or a simple associative array or something else entirely - it really doesn"t matter.

Inside this method you will define and return the transformed data as an associative array.


```php
use Nimbly\Remodel\Transformer;

class UserTransform extends Transformer
{
    public function transform(User $user): array
    {
        return [
            "id" => (int) $user->id,
            "name" => $user->name,
            "email" => $user->email,
            "created_at" => \date("c", $user->created_at)
        ];
    }
}
```

With our `UserTransformer` now defined, let's pull a user from the database and transform it. In order to transform the user data, we must map the data to be transformed to a specific transformer.

To do this we create a new `Item` subject since we are transforming a single item. If this were a collection of users, we would use the `Collection` subject.

```php
// Grab the user from the database
$user = App\Models\User::find($id);

// Create a new Item subject using the UserTransformer
$subject = new Nimbly\Remodel\Subjects\Item($user, new UserTransformer);
```

## Including related data automatically

What good is a transformer if it can only transform the object you've given it? Real use cases are far more complex.
What if you need to transform a book whose author is stored in a separate model instance and needs its own transformation?
What if we need the most recent user reviews posted about the book?

Add the protected `$defaultIncludes` array property on the transformer containing all the default includes you would like.
Remodel will then look for a method on the transformer with name "{include}Include". For example:

```php
class BookTransformer extends Transformer
{
    protected $defaultIncludes = ["author", "reviews"];

    public function transform(Book $book): array
    {
        return [
            "id" => (int) $book->id,
            "title" => $book->title,
            "genre" => $book->genre,
            "isbn" => $book->isbn,
            "published_at" => date("c", $book->published_at)
        ];
    }

    /**
     *
     * Remodel will call this method automatically for you since it's in the list of
     * $defaultIncludes above.
     *
     */
    public function authorInclude(Book $book): Subject
    {
        return new Item($book->author, new AuthorTransformer);
    }

    /**
     *
     * Return an array of reviews.
     *
     */
    public function reviewsInclude(Book $book): Subject
    {
        return new Collection($book->reviews, new ReviewTransformer);
    }
}
```

Now let's create the Transformer for our Author object.

```php
class AuthorTransformer extends Transformer
{
    public function transform(Author $author)
    {
        return [
            "id" => (int) $author->id,
            "name" => $author->name
        ];
    }
}
```

## Nested includes

What if you need an optional include on another include? For example, if the Author also has an Address object that is not included by default?

You can nest includes by using a dot notation.

```php
protected $defaultIncludes = ["author.address"];
```

This will include an Author and its Address object.

You can nest as many includes as you"d like and to an unlimited depth.

```php
protected $defaultIncludes = ["comments.user.profile"];
```

## Transforming a collection of subjects

You can transform a collection or array of subjects in a similar fashion.

```php
$collection = new Nimbly\Remodel\Subjects\Collection($books, new BookTransformer);
```

## Adding includes at run time

What if you don"t always need a related subject included with every transformation? Maybe it's a resource
provided only when the requesting client needs it?

You can pass run-time user supplied includes into the Transformer instance using the `setIncludes` method.

```php
$transformer = new BookTransformer;
$transformer->setIncludes(["author", "publisher"]);
```

## Overriding default includes at run time

You can override the default includes at runtime by calling the `setDefaultIncludes` method.

```php
$transformer = new BookTransformer;
$transformer->setDefaultIncludes(["comments"]);
```