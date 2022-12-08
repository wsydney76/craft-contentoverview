# Plugin config

Create a file `contentoverview.php` in your config folder. See [docs](https://craftcms.com/docs/4.x/extend/plugin-settings.html#overriding-setting-values).

Settings in alphabetical order:

- altTemplate (string, object template used to render the alt attribute of images, defaults to `{alt}`)
- custom (array, can contain any data you want to use somewhere in your setup.)
- customTemplatePath (string, folder for custom templates, defaults to _contentoverview)
- defaultIcon (string, file path to a svg icon, defaults to @coicons/newspaper.svg)
- defaultLayout (string, the layout that is used by default. list (default)|cardlets|cards|line)
- defaultPage (string, page key for the first/only page. Defaults to 'default'.)
- enableCreateInSlideoutEditor (bool, whether new entries will be created in a slideout editor. Defaults to false on multi-site installs, else true. Experimental)
- enableSlideoutEditor (bool, whether a slideout editor can be opened for an entry by a double click on the status indicator, or by clicking an icon/image. Experimental)
- extraPermissions (array, adds permissions)
- enableWidgets (bool, default true, enable dashboard widgets that display a single tab)
- fallbackImage (Asset, an image that will be used in a layout if no image is set on an entry)
- hideUnpermittedSections (bool, Whether to hide sections a user does not have view permission instead of displaying a message. May lead to ugly empty tabs.)
- layoutSizes (array, which size is used by default for a layout)
- layoutWidth (array, the grid column width for a layout size. Technically the `minmax` value for a `grid-template-columns` css directive.)
- linkTarget (string, defaults to '_blank' to open edit screens in a new tab (default).)
- loadSectionsAsync (bool, Whether to load section html via ajax request. Loads section content when it becomes visible.)
- pluginTitle (string, label for primary navigation, page title. Defaults to 'Content Overview')
- purifierConfig (string|array The html purifier config used to make output from object templates safe.)
- replaceDashboard (bool Whether to remove dashboard link and redirect to contentoverview on login.)
- showLoadingIndicator (bool, Whether to show a loading indicator/overlay while an ajax request is pending.)
- showPages (string, default nav, where to show multiple pages: nav|sidebar|no)
- transforms (array, image transforms for layouts)
- useImagerX (bool, create image transforms with Imager-X plugin, if available. Defaults to true)
- widgetText (string, text for dashboard link widget)

Defaults are defined in `models\Settings.php`.

```php
<?php

return [
    'replaceDashboard' => true,
    'enableWidgets' => false,
];
```

## Single Page Setup

By default, a link to a single page is added to the navigation sidebar.

![screenshot](/images/nav1.jpg)

This requires a setup up file named after the `defaultPage` settings.

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

defaultPage: the page that is initially selected. Usually the first one.

pages: an array of page configs

* label: Label for nav and page titles

* group: this page should only be available for admins/members of this group/one of these groups.
  Can be a string (one group) or an array of group handles.

* permission: this page should only be available for admins/users with this permission.

* blocks: array of templates that will be rendered inside a Control Panel twig block area. See Templates chapter below.


By default, multiple pages are display as subNav:

![screenshot](/images/nav2.jpg)

Alternatively, the pages can be displayed in the sidebar.

Set the `showPage` plugin setting to 'sidebar'.

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


## Widgets

A single tab can be used as dashboard widget.

Define them in a special `config/contentoverview/widgets.php` page config file.

````php
<?php

use wsydney76\contentoverview\services\ContentOverviewService;

$co = new ContentOverviewService();

return [
    'tabs' => [
        $co->createTab('Site', require 'tab1.php'),
        $co->createTab('News', require 'tab2.php'),
    ]
];
````