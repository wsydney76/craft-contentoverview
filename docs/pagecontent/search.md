# Searching

Add searching to a section by setting the `search` attribute to true:

```php
->search(true)
```

![Screenshot](/images/search1.jpg)

The search will be executed respecting `defaultSearchTermOptions` in your general settings.

## Search attributes

A search can be narrowed down by adding a prefix that defines a field to search in, like `title:whatsoever`.

You can add a `searchAttributes` section config setting to make that easier for your user.

```php
->searchAttributes([
    ['label' => 'Title', 'value' =>  'title'],
    ['label' => 'Body Content', 'value' =>  'bodyContent'],
])
```

This will add a dropdown:

![Screenshot](/images/search2.jpg)

The prefix will be automatically added to the search query.