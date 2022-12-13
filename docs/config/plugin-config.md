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

```php
'altTemplate' => '{altText}'
```


## customTemplateRoot 

* Type: `string`
* Default: `@templates/_contentoverview` 

Root folder for custom templates. By default `templates/_contentoverview`, unless you configured your templates to live elsewhere.

Can contain an alias.

```php
'customTemplatePath' => '@templates/_mypath'
```

## defaultIcon 

* Type: `string`
* Default: `@coicons/newspaper.svg` 

File path to a svg icon.

```php
'defaultIcon' => '@templates/icons/default.svg'
```

## defaultLayout 

* Type: `string`
* Default: `list` 

The layout that is used by default. list|cardlets|cards|line.

```php
'defaultLayout' => 'cardlets'
```

## defaultPage 

* Type: `string`
* Default: `default` 

Page key for the first/only page.

```php
'defaultPage' => 'page1'
```

## enableCreateInSlideoutEditor

* Type: `bool`
* Default: `true`

Whether a slideout editor will be opened to create a new entry. Experimental.

Will be forced to `false` in a multi-site setup.

```php
'enableCreateInSlideoutEditor' => false
```

## enableSlideoutEditor

* Type: `bool`
* Default: `true`

Whether a slideout editor can be opened for an entry by a double click on the status indicator, or by clicking an icon/image. Experimental.

```php
'enableSlideoutEditor' => false
```

## extraPermissions 

* Type: `array` 

Adds permissions. See [Permissions](../misc/permissions).

```php
'extraPermissions' => [
  'festivalAdmin' => [
      'label' => 'Festival Admin'
  ]
]
```

## enableWidgets 

* Type: `bool`
* Default: `true` 

Whether to enable dashboard widgets that display a single tab.

```php
'enableWidgets' => false
```

## fallbackImage 

* Type: `Asset`

An image that will be used in a layout if no image is set on an entry.

```php
'fallbackImage' => GlobalSet::find()
    ->handle('siteInfo')->one()
    ->featuredImage->one(),
```

## hideUnpermittedSections 

* Type: `bool`
* Default: `false` 

Whether to hide sections a user does not have view permission instead of displaying a message. May lead to ugly empty tabs.

```php
'hideUnpermittedSections' => true
```

## layoutSizes 

* Type: `array`
* Default:

 ```php
 [
  'cards' => 'card',
  'cardlets' => 'large'
  ]
  ```

Which size is used by default for a layout.

```php
->layoutSizes([
  'cards' => 'small',
  'cardlets' => 'medium'
  ])
```

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

```php
'linkTarget' => ''
```

## loadSectionsAsync 

* Type: `bool`
* Default: `false` 

Whether to load section html via ajax request. Loads section content when it becomes visible.

```php
'loadSectionsAsync' => true
```

## pluginTitle 

* Type: `string`
* Default: `Content Overview` 

Label for primary navigation, page title.

Has to be translated via the `site` category, as it can be project specific.

```php
'pluginTitle' => 'Content'
```

## purifierConfig 

* Type: `string|array`

The html purifier config used to make output from object templates safe. See [purify filter docs](https://craftcms.com/docs/4.x/dev/filters.html#purify).

Uses the default config if empty.

```php
'purifierConfig' => 'yourConfig'
```

## replaceDashboard 

* Type: `bool`
* Default: `false` 

Whether to remove dashboard link and redirect to contentoverview on login.

```php
'replaceDashboard' => true
```

## showLoadingIndicator 

* Type: `bool`
* Default: `false` 

Whether to show a loading indicator/overlay while an ajax request is pending.

```php
'showLoadingIndicator' => true
```

## showPages 

* Type: `string`
* Default: `nav` 

Where to show multiple pages: 

* nav: in main navigation
* sidebar: in sidebar
* no: not at all
* 
```php
'showPages' => 'sidebar'
```

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

```php
'useImagerX' => false
```

## widgetText 

* Type: `string`
* Default: `Get a quick overview of your content` 

Text for dashboard link widget

Has to be translated via the `site` category, as it can be project specific.

```php
'widgetText' => 'Goto Content Overview page'
```