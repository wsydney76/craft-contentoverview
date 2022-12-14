# Custom Action Classes

A custom action class can be used to determine whether an action is available for an entry.

```php
$co->createAction(PublishAction::class)
```

The class can (optionally) define the action settings, and should implement the `isActiveForEntry` method.

```php
<?php

namespace modules\contentoverview\models;

use craft\elements\Entry;
use wsydney76\contentoverview\models\Action;

class PublishAction extends Action
{
    public string $label = 'Publish all entries that belong to this package';
    public string $icon = '@templates/_icons/publish.svg';
    public string $cpAction = 'main/content/publish-release';
    public string $handle = 'publishAction';

    public function isActiveForEntry(Entry $entry): bool
    {
        // your logic here
        return $entry->status === 'disabled';
    }
}
```

::: tip
Runing `php craft contentoverview/create/action` will create a file as a starting point for you.
:::