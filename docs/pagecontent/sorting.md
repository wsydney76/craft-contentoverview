# Sorting

You can overwrite Crafts default order by specifying a custom sort order in your section config

```php
->orderBy('title')
```

If you want to offer your editors some predefined sort options, configure them in an array:

```php
->orderBy([
    ['label' => 'Post Date', 'value' => 'postDate desc'],
    ['label' => 'Creation Date', 'value' => 'dateCreated desc'],
    ['label' => 'Title', 'value' => 'title'],
    ['label' => 'Random', 'value' => 'RAND()'],
]),
```

A dropdown will be rendered next to filters.

The first option will be used when initially loading the page.