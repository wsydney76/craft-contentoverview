# Pages Setup

## Single Page Setup

By default, a link to a single page is added to the navigation sidebar.

![screenshot](/images/nav1.jpg)

This requires a config file named after the [defaultPage](./plugin-config#defaultpage) plugin setting, e.g. `config/contentoverview/default.php`.

## Multi Page Setup

You can configure multiple pages by adding them to the `config/contenoverview/pages.php` file.

```php
<?php

use wsydney76\contentoverview\services\ContentOverviewService;

$co = new ContentOverviewService();

return [
    // the page key, used for building the page url and for identifying the page in ajax requests
    $co->createPage('page1')  
        ->label('Site/News'),

    $co->createPage('festival')
        ->label('Festival')
        ->blocks(['details' => 'custom/festival_help'])
        ->group(['festivalAdmins', 'festivalEditors']),
]
```

### Settings

Settings for the page object:

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