# Service Class

`wsydney\contentoverview\services\ContentOverviewService`

The `ContentOverviewService` class serves as a factory for creating all classes in this plugin, and implements some common functions.

To replace it, add this to your `config\contentoverview.php` file:

```php
'serviceClass' => MyService::class
```

```php
<?php

namespace modules\contentoverview\services;

use wsydney76\contentoverview\services\ContentOverviewService;

class MyService extends ContentOverviewService
{

}
```

::: tip
Runing `php craft contentoverview/create/service` will create a file as a starting point for you.
:::

Your class gets registered as the `contentoverview` component and is now available in your config files:

```php
use wsydney76\contentoverview\Plugin;
...
$co = Plugin::getInstance()->contentoverview;
```

::: warning
If you want to use your new service class in the main config file `config/contentoverview.php`, you have to
create it via `$co = new MyService()`, because the plugin is not yet initialized at this point. 
:::

## Methods

### Factory methods

These methods create configuration objects. See configuration chapters for details.

Example:

```php
public function createPage(string $pageKey): Page
```

### getPages

```php
public function getPages(): Collection
```

Returns configured pages.

### getPageByKey

```php
public function getPageByKey(string $pageKey): Page
```

Returns a page object by its page key.

### getSectionByPath

```php
public function getSectionByPath(string $sectionPath): Section
```

Returns a section config object by its path.

The path is composed as `pageKey-tabIndex-columnIndex-sectionIndex`, e.g. `page1-0-0-1`.