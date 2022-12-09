# Plugin config

Create a file `contentoverview.php` in your config folder. See [docs](https://craftcms.com/docs/4.x/extend/plugin-settings.html#overriding-setting-values).

```php
<?php

return [
    'replaceDashboard' => true,
    'enableWidgets' => false,
];
```

Settings in alphabetical order:

If no default value is mentioned, the setting will default to `empty` (empty string, empty array, null, depending on the type).

## altTemplate 

* Type: `string`
* Default: `{alt}` 

Object template used to render the alt attribute of images, defaults to `{alt}`

## customTemplatePath 

* Type: `string`
* Default: `_contentoverview` 

Folder for custom templates inside the `templates` project folder.

## defaultIcon 

* Type: `string`
* Default: `@coicons/newspaper.svg` 

File path to a svg icon.

## defaultLayout 

* Type: `string`
* Default: `list` 

The layout that is used by default. list|cardlets|cards|line.

## defaultPage 

* Type: `string`
* Default: `default` 

Page key for the first/only page.

## enableCreateInSlideoutEditor 
bool, whether new entries will be created in a slideout editor. Defaults to false on multi-site installs, else true. Experimental

## enableSlideoutEditor 

* Type: `bool`
* Default: `true` 

Whether a slideout editor can be opened for an entry by a double click on the status indicator, or by clicking an icon/image. Experimental

## enableCreateInSlideoutEditor

* Type: `bool`
* Default: `true`

Whether a slideout editor will be opened to create a new entry. Experimental

Will be forced to `false` in a mult-site setup.


## extraPermissions 

* Type: `array` 

Adds permissions. See [Permissions](../misc/permissions)

## enableWidgets 

* Type: `bool`
* Default: `true` 

Whether to enable dashboard widgets that display a single tab.

## fallbackImage 

* Type: `Asset`

An image that will be used in a layout if no image is set on an entry.

## hideUnpermittedSections 

* Type: `bool`
* Default: `false` 

Whether to hide sections a user does not have view permission instead of displaying a message. May lead to ugly empty tabs.

## layoutSizes 

* Type: `array`
* Default:

 ```php
 [
  'cards' => 'card',
  'cardlets' => 'large'
  ]
  ```

Which size is used by default for a layout

## layoutWidth 

* Type: `array`
* Default: 

```php
[
    'tiny' => '10rem,1fr',
    'small' => '16rem,1fr',
    'medium' => '24rem,1fr',
    'large' => '36rem,1fr',
    'card' => '280px,450px' // don't let cards exceed the image width
]
```


The grid column width for a layout size. Technically the `minmax` value for a `grid-template-columns` css directive.

## linkTarget 

* Type: `string`
* Default: `_blank` 

The value of a `target` attribute added to the links that open an edit page.

## loadSectionsAsync 

* Type: `bool`
* Default: `false` 

Whether to load section html via ajax request. Loads section content when it becomes visible.

## pluginTitle 

* Type: `string`
* Default: `Content Overview` 

Label for primary navigation, page title.

Has to be translated via the `site` category, as it can be project specific.

## purifierConfig 

* Type: `string|array`

The html purifier config used to make output from object templates safe.

Uses the default config if empty.

## replaceDashboard 

* Type: `bool`
* Default: `false` 

Whether to remove dashboard link and redirect to contentoverview on login.

## showLoadingIndicator 

* Type: `bool`
* Default: `false` 

Whether to show a loading indicator/overlay while an ajax request is pending.

## showPages 

* Type: `string`
* Default: `nav` 

Where to show multiple pages: 

* nav: in main navigation
* sidebar: in sidebar
* no: not at all

## statusFilterOptions

* Type: `array`
* Default:

```php
[
    ['label' => 'Drafts', 'value' => 'scope:drafts'],
    ['label' => 'My Drafts', 'value' => 'scope:drafts,ownDraftsOnly:true'],
    ['label' => 'My Provisional Drafts', 'value' => 'scope:provisional,ownDraftsOnly:true'],
    ['label' => 'Disabled', 'value' => 'status:disabled'],
    ['label' => 'Expired', 'value' => 'status:expired'],
    ['label' => 'Pending', 'value' => 'status:pending'],
]
```

The options used for the [status filter type](../pagecontent/filters#status-filter).

Comma separated list of `setting:value`.

## transforms 

* Type: `array`
* Default:

```php
[
    'list' => ['width' => 50, 'height' => 50, 'format' => 'webp'],
    'cardlets' => ['width' => 150, 'height' => 150, 'format' => 'webp'],
    'cards' => ['width' => 450, 'height' => 225, 'format' => 'webp'],
    'line' => null, // no image in line layout
    'table' => ['width' => 60, 'height' => 30, 'format' => 'webp']
]
```

Image transforms for layouts.

The `height` will be adjusted if a `imageRatio` setting is used.

## useImagerX 

* Type: `bool`
* Default: `true` 

Create image transforms with Imager-X plugin, if available.

## widgetText 

* Type: `string`
* Default: `Get a quick overview of your content` 

Text for dashboard link widget

Has to be translated via the `site` category, as it can be project specific.