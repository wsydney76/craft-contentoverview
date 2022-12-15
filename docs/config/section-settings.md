# Section settings

Settings for sections, in alphabetical order:

```php
$co->createSection(
    ->layout('cards')
```

If no default value is mentioned, the setting will default to `empty` (empty string, empty array, null, depending on the type).

## actions 

* Type: `array` 

The actions available to the section. See [Actions](../pagecontent/actions).

```php
->actions([
    'slideout', // Predefined actions
    'delete',
    'view',
    $co->createAction(...),
    $co->createAction(...),
])

```

## allSites 

* Type: `bool`
* Default: `false` 

true = display unique entries from all sites.

```php
->allSites(true)
```

## entryType 

* Type: `array|string`

Narrow query results by entryType handle

```php
->entryType('privacy')
```

## fallbackImageField 

* Type: `array|string`

Name of an image field to use if there is no image set in `imageField`.

```php
->fallbackImageField('photo')
```

## filters 

* Type: `array`

Array of filter definitions. See [Filters](../pagecontent/filters).

```php
->filters([   
    $co->createFilter('field', 'topics'),    
    $co->createFilter('field', 'workflowStatus'),
])
```

## filtersPosition

* Type: `string`
* Default: `inline`

Positions of filter inputs.

* `inline` beneath search inputs
* `top` above search inputs
* `bottom` below search inputs

```php
->filtersPosition('bottom')
```

## heading 

* Type: `string`

Heading of the section. The `Section::getHeading()` method will return Crafts section names, if this setting is empty.

```php
->heading('Upcoming Events')
```

## help 

* Type: `array|string`

Help text for the section. See [Help](../pagecontent/help) for more options.

```php
->help('Help is on the way!')
```

## icon 

* Type: `array|string`

Path to a svg icon that will be displayed if no image is found. Can contain aliases.

See [Multi Section Setup](./page-config#multi-section-setup).

```php
->icon('@appicons/wand.svg')
```

## iconBgColor 

* Type: `string`
* Default: `var(--gray-200)` 

The background color for an icon.

```php
->iconBgColor('#e4e4e4')
```

## imageField 

* Type: `array|string`

Name of the image field to use.

See [Multi Section Setup](./page-config#multi-section-setup).

```php
->imageField('featuredImage')
```

## imageRatio 

* Type: `float`

Aspect ratio of the image. Only makes sense for card layout.

If empty, the [transforms](./plugin-config#transforms) setting wil determine the aspect ratio.

```php
->imageRatio(5/4)
```

## info 

* Type: `string|array`

Object template to render in addition to the title.

See [Multi Section Setup](./page-config#multi-section-setup).

```php
->info('{postDate|date("short")}')
```

## infoTemplate 

* Type: `string|array`

Path to a twig template inside the [custom template root](./plugin-config#customtemplateroot). Will be called with `entry` and `sectionConfig` variable.

See [Multi Section Setup](./page-config#multi-section-setup).

```php
->infoTemplate('infos/workflowstatus.twig')
```

## layout 

* Type: `string`

The layout used to display entries. (list|cardlets|cards|line|table)

The `Section::getLayout()` method will take the [defaultLayout](./plugin-config#defaultlayout) plugin setting into account, if this setting is empty.

```php
->layout('cards')
```

## limit 

* Type: `int`
* Default: `9999` 

Number of entries to show on one section page.

```php
->limit(12)
```

## linkToPage 

* Type: `string` 

The key of a page the heading is linked to. May contain an anchor, e.g. `page1#tab1`.

```php
->linkToPage('page1')
```

## orderBy

* Type: `string|array`

The sort order used by the sections query. If empty, the Crafts defaults will be used.

See [docs](https://craftcms.com/docs/4.x/entries.html#orderby)

```php
->orderBy('postDate desc')
```

## ownDraftsOnly 

* Type: `bool`
* Default: `false` 

If true and scope is defined: show only drafts created by the current user.

```php
->ownDraftsOnly(true)
```

## query 

* Type: `ElementQuery`

Define your own query.

```php

use craft\elements\Entry;

->query(Entry::find()->customField('value'))
```

## scope 

* Type: `string` 

Whether drafts should be shown.

* drafts: Show 'regular' drafts
* provisional: Show 'provisional' drafts
* ownProvisional: Show own 'provisional' drafts
* all: Show all drafts and all 'published' entries

If empty, only 'published' entries will be included.

```php
->scope('drafts')
```

## search 

* Type: `bool`
* Default: `false` 

Whether search will be enabled.

```php
->search(true)
```

## searchAttributes

* Type: `array`

Prefixes for search. See [Searching](../pagecontent/search#search-attributes).

```php
->searchAttributes([
    ['label' => 'Title', 'value' =>  'title'],
    ['label' => 'Body Content', 'value' =>  'bodyContent'],
])
``` 

## section 

* Type: `array|string`

Craft section handle(s).

Will be passed to the section query, however if a `query` setting is set, it will only be used for default headings/permission checks.

```php
->section('news')
```

## showIndexButton 

* Type: `bool`
* Default: `true` 

Whether button 'All entries' will be shown.

```php
->showIndexButton(false)
```

## showNewButton 

* Type: `bool`
* Default: `true`

Whether button 'New entry' will be shown.

```php
->showNewButton(false)
```


## showRefreshButton 

* Type: `bool`
* Default: `true`

Whether to show a refresh button for this section.

```php
->showRefreshButton(false)
```


## size 

string, the grid colum size of an entry for layouts card, cardlet. (tiny|small|medum|large|card)

```php
->size('small')
```

## sortByScore 

* Type: `bool`
* Default: `false`

Whether search results will be sorted by score.

```php
->sortByScore(true)
```

## status 

* Type: `string|array`

See [docs](https://craftcms.com/docs/4.x/entries.html#status)

If empty, all entries with all status (live, disabled, pending, expired) will be found.

```php
->status('pending')
```

## titleObjectTemplate 

* Type: `string`
* Default: `{title}` 

An object template that will be rendered for the title in a layout.

```php
->titleObjectTemplate('{lastName}, {firstName}')
```