# Section

`wsydney76\contentoverview\models\Section`

This is the model you would most likely override to add your own features.

```php
namespace modules\contentoverview\models;

use wsydney76\contentoverview\models\Section;

class MySection extends Section {
...
}
```
::: tip
Runing `php craft contentoverview/create/section` will create a file as a starting point for you.
:::


## Inject your class

There are two ways to inject your class:

To use it globally, add this to your `config/contentoverview.php` file:

```php
use modules\mymodule\models\MySection;
...
return [
    ...
    'sectionClass' => MySection::class,
    ...
]
```

To use it for an individual section, create it like this:

```php
use modules\mymodule\models\MySection;
...

$co->createSection(MySection::class)
```

## Your own defaults

You can overwrite settings to use your own defaults:

```php
public ?int $limit = 12;
public array|string $imageField = 'featuredImage';
public ?string $layout = 'cardlets';
```

::: tip About types
Note that you have to use exactly the same types as in the base class. Your IDE will help, e.g. in PhpStorm just type the name of the setting and type 'TAB'.
:::

## Your own settings

You can also add your own query params.

For example if you want the results filtered by topic (entries field):

```php
// By Slug
->topic('sports')

// By element
$element = ... get a topic entry element here ... 
...
->topic($topicEntry)
```

Add a property to your class:

```php
public mixed $topic = null;
```

Add a setter function to your class:

```php
/**
 * Filter by topic (slug or element)
 *
 * @param string $topic
 * @return $this
 */
public function topic(mixed $topic): self
{
    $this->topic = $topic;
    return $this;
} 
```
    
In order to apply a query parameter, overwrite the `getQuery` method:

```php
public function getQuery(array $params): ElementQueryInterface
{
    // Get a query with all other parameters applied
    $query = parent::getQuery($params);

    if ($this->topic) {
        if (is_string($this->topic)) {
            // Get entry by slug 
            $this->topic = Entry::find()->section('topic')->slug($this->topic)->ids();
        }
        
        // Add query parameter
        if ($this->topic) {
            $query->andRelatedTo(['targetElement' => $this->topic, 'field' => 'topics'] );
        }
    }

    return $query;
}
```

## Eager loading

In case you refer to related elements in your `info`/`infoTemplate` templates, you can add eager loading like this:

```php
public function getQuery(array $params): ElementQueryInterface
{
    return parent::getQuery($params)
        ->andWith('topics')
        ->andWith('assignedTo');
}
```

## Methods

There are a number of settings that you should not access directly, but call/override a getter method that will apply their own rules/defaults/fallbacks.

### getHeading

```php
public function getHeading(): string
```

Get section heading, returns Craft section names by default.

### getLayout

```php
public function getLayout(): string
```

Returns the layout (cards, cardlets, ...) to use for this section.

### getSize

```php
public function getSize(): string
```

Returns the size (large, medium, ...) to use for this section.

### getTransform

```php
public function getTransform(): array
```

Returns the image transform to use for this section.

### getPermittedSections

```php
public function getPermittedSections(string $permission): array
```

Returns the Craft sections that the current user has permission (viewentries, saveentries) for.

### getFilters

```php
public function getFilters(): Collection
```

Returns a collection of `Filter` models to use for this section.

### getActions

```php
public function getActions(): Collection
```

Returns a collection of `Action` models to use for this section.

### getOrderByOptions

```php
public function getOrderByOptions(): Collection
```

Return options for custom sort.

### getEntries

```php
public function getEntries(array $params = []): Paginator
```

Returns a [Paginator](https://docs.craftcms.com/api/v4/craft-db-paginator.html) object that holds the result of the executed query.

For value of `$params` see `getQuery`.

### getQuery

```php
public function getQuery(array $params): ElementQueryInterface
```

Returns the `query` object that defines the query to be executed.

Override this to add your own query parameters.

`$params` can contain:

* q: a search term for full text search.
* orderBy: sort order.
* filters: array of filters to apply.
* * type: type of filter, e.g. `entriesField`, `status`, `custom`
* * handle: field handle, custom handle
* * value: the value select by user
* sectionPageNo: the page number to use for pagination.

### getImage

```php
public function getImage(Entry $entry): ?Asset
```

Gets the image asset element to use for an entry.

### getInfoContent

```php
public function getInfoContent(Entry $entry): string
```

Gets the info content.


