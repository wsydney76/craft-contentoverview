# Pages Setup

## Single Page Setup

By default, a link to a single page is added to the navigation sidebar.

![screenshot](/images/nav1.jpg)

This requires a config file named after the [defaultPage](./plugin-config#defaultpage) plugin setting, e.g. `config/contentoverview/default.php`.

## Multi Page Setup

You can configure multiple pages by adding them to the `config/contenoverview/pages.php` file.

```php
<?php

use wsydney76\contentoverview\Plugin;

$co = Plugin::getInstance()->contentoverview;

return [   
    $co->createPage('page1')  
        ->label('Site/News'),

    $co->createPage('festival')
        ->label('Festival')
        ->blocks(['details' => 'custom/festival_help'])
        ->group(['festivalAdmins', 'festivalEditors']),
]
```

::: tip
Runing `php craft contentoverview/create/pages` will create this file as a starting point for you.
:::


### Settings

The `createPage` method is called with a `pageKey` parameter, which is used to build the URL of the page (e.g. `/admin/contentoverview/festival`) 
and internally to identify the page in ajax request.

Other settings for the page object:

#### label

* Type: `string`

Label for nav and page titles.

#### group/permission

See [Common Settings](./common)

Restrict access to this page.

#### blocks

* Type: `array` 

Array of templates that will be rendered inside a Control Panel twig block area. See [Templates](../customize/templates).

### Show page links

Where links to your subpages appear:

#### Subnav

By default, multiple pages are displayed as subNav:

![screenshot](/images/nav2.jpg)

#### Sidebar

Alternatively, the pages can be displayed in the sidebar.

Set the [showPages](./plugin-config#showpages) plugin setting to 'sidebar'.

This is more consistent with the rest of the CP and is more convenient when many pages are displayed and grouping is
useful , however it consumes more space.

```php
   'showPages' => 'sidebar',
```

Heading rows (page groups) and icons can be added to the config in `config/contentoverview/pages.php`:

```php
$co->createPageGroup()
        ->label('Workflow')
    
$co->createPage('page2')
    ->label('Needs attention!')
    ->icon('@appicons/clock.svg')
```

![Screenshot](/images/sidebar.jpg)

## Dynamic pages

Pages can be called without being configured in the `pages` config file, e.g. `/contentoverview/package?elementId=1838`.

This can be used in actions, where you want to link to a page that shows specific content related to an entry.

```php
$co->createAction()
    ->label('Details')
    ->icon('@appicons/wand.svg')
    ->cpUrl('contentoverview/package')
```

You must setup your own [section class](../dev/section) to handle the query parameter and resulting queries.

```php
<?php

// config/contentoverview/package.php

use wsydney76\contentoverview\Plugin;
use wsydney76\package\models\PackageSection;

$co = Plugin::getInstance()->contentoverview;

return [
    'sections' => [
        $co->createSection(PackageSection::class)
            ->section(['news'])
    ]
];
```

Query params will be passed through to ajax requests as `extraParams`.