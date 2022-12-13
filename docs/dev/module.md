# Setting up a Custom Module

If you want to listen to events or bring up your own classes, you set up a custom module.

::: tip
It is completely up to you how you organize your code. However, we recommend building a dedicated custom module named `contentoverview`.

This is also the convention followed in this docs.
:::

This could be your directory structure in your projects root:

```
├─ modules
│  ├─ contentoverview
│  │  ├─ filters
│  │  │  └─ MyCustomFilter.php
│  │  │  └─ ... more classes ...
│  │  ├─ models
│  │  │  └─ MySection.php
│  │  │  └─ ... more classes ...
│  │  ├─ services
│  │  │  └─ MyServices.php
│  └─ ContentOverviewModule.php
```

* filters: The directory that contains your custom filter classes.
* models: The directory that contains your custom model classes.
* ContentOverviewModule.php: The main module class where you can place your event listeners.

## Custom classes

Make the plugin use it globally add this to your `config/contentoverview.php` file:

```php
use modules\mymodule\models\MySection;
...
return [
    ...
    'sectionClass' => MySection::class,
    ...
]
```

These are the classes you can override like this:

```php
public string $serviceClass = ContentOverviewService::class;
public string $pageClass = Page::class;
public string $tabClass = Tab::class;
public string $columnClass = Column::class;
public string $sectionClass = Section::class;
public string $actionClass = Action::class;
public string $filterClass = Filter::class;
public string $statusFilterClass = StatusFilter::class;
public string $usersFieldFilterClass = UsersFieldFilter::class;
public string $entriesFieldFilterClass = EntriesFieldFilter::class;
public string $matrixFieldFilterClass = MatrixFieldFilter::class;
public string $optionsFieldFilterClass = OptionsFilter::class;
public string $customFilterClass = CustomFilter::class;
public string $tableSectionClass = TableSection::class;
public string $tableColumnClass = TableColumn::class;
```

Additionally, some 'ContentOverviewService' methods like `createSection`, `createAction`, `createCustomFilter` allow you to pass in a class name as parameter


## Listening to events

In order to enable your module to listen to events, you have to create a main module class and make Craft load it on every request.

Create a file  `modules/contentoverview/ContentOverviewModule.php` and enter this content:

```php
<?php

namespace modules\contentoverview;

use Craft;
use yii\base\Module;

class ContentOverviewModule extends Module
{
    public function init()
    {
        // There is nothing to do here if it is not a Control Panel request, or if we are on the login page.
        if (!Craft::$app->request->getIsCpRequest() || Craft::$app->request->getIsLoginRequest()) {
            return;
        }
        
        // Your event listeners go here....
        
    }
}
```

Edit your `config/app.php` file:

```php

use modules\contentoverview\ContentOverviewModule;

...

return [
    // ...
    'modules' => [
        // ...
        'contentoverview' => ContentOverviewModule::class
    ],
    'bootstrap' => [
        // ...
        'contentoverview',
    ],
];
```

## Moving your config directory to your module

The pages configuration by default lives in `config/contentoverview`.

To keep things together, you may want to move it into your modules' folder:

```php
// config/contentoverview.php
'configPath' => '@root/modules/contentoverview/config',
```

## Moving your templates directory to your module

Custom templates by default live in `templates/_contentoverview`. 

To keep things together, you may want to move them into your modules' folder:

```php
// config/contentoverview.php
'customTemplateRoot' => '@root/modules/contentoverview/templates',
```


