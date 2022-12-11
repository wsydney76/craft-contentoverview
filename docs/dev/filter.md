# Custom Filter Classes

Custom filter classes implement [Custom Filters](../pagecontent/filters#custom-filters).

Inject your class via the `createCustomFilter` factory method:

```php
$co->createCustomFilter(MyFilter::class);
```

## Methods

You can override the following methods:

### getLabel

```php
public function getLabel(): string
```

Returns the label used for the select box.

### getOptions

```php
public function getOptions(): array|Collection
```

Returns the options used for the select box.

### modifyQuery

```php
public function modifyQuery(Section $sectionConfig, array $filter, ElementQueryInterface $query)
```

This is mandatory for custom filters.

See [example](../pagecontent/filters#filter-class-example).