# Widget Sections (experimental)

Dashboard widgets can be displayed:

```php
use craft\widgets\MyDrafts;
...
$co->createWidgetSection()
    // optional, defaults to widget title
    ->heading('Drafts created by me')
    ->widget(new MyDrafts([
        'limit' => 20
    ])),
```

This just calls the constructor and the `getBodyHtml` method of the widget. The widget is not
loaded in the context it expects, so it may or may not work properly. (Javascript errors, missing css etc).