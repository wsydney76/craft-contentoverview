# Section settings

Settings for sections, in alphabetical order:

```php
$co->createSection(
    ->layout('cards'
```

If no default value is mentioned, the setting will default to `empty` (empty string, empty array, null, depending on the type).

## actions 

* Type: `array` 

The actions available to the section. See [Actions](../pagecontent/actions).

## allSites 

* Type: `bool`
* Default: `false` 

true = display unique entries from all sites.

## entryType 

* Type: `array|string`

EntryType handle

## fallbackImageField 

* Type: `array|string`

Name of an image field to use if there is no image set in `imageField`.

## filters 

* Type: `array`

Array of filter definitions. See [Filters](../pagecontent/filters).

## filtersPosition

* Type: `string`
* Default: `inline`

Positions of filter inputs.

* `inline` beneath search inputs
* `top` above search inputs
* `bottom` below search inputs

## heading 

* Type: `string`

Heading of the section. The `Section::getHeading()` method will return Crafts section names, if this setting is empty.

## help 

* Type: `array|string`

Help text for the section. See [Help](../pagecontent/help).

## icon 

* Type: `array|string`

Path to a svg icon that will be displayed if no image is found.

See [Multi Section Setup](./page-config#multi-section-setup).

## iconBgColor 

* Type: `string`
* Default: `var(--gray-200)` 

The background color for an icon.

## imageField 

* Type: `array|string`

Name of the image field to use.

See [Multi Section Setup](./page-config#multi-section-setup).

## imageRatio 

* Type: `float`

Aspect ratio of the image. Only makes sense for card layout.

If empty, the [transforms](./plugin-config#transforms) setting wil determine the aspect ratio.

## info 

* Type: `string|array`

Object template to render in addition to the title.

See [Multi Section Setup](./page-config#multi-section-setup).

## infoTemplate 

* Type: `string|array`

Path to a twig template inside the projects templates folder. Will be called with an entries variable.

See [Multi Section Setup](./page-config#multi-section-setup).

## layout 

* Type: `string`

The layout used to display entries. (list|cardlets|cards|line|table)

The `Section::getLayout()` method will take the [defaultLayout](./plugin-config#defaultlayout) plugin setting into account, if this setting is empty.

## limit 

* Type: `int`
* Default: `9999` 

Number of entries to show on one section page.

## linkToPage 

* Type: `string` 

The key of a page the heading is linked to. May contain an anchor, e.g. `page1#tab1`.

## orderBy

* Type: `string|array`

The sort order used by the sections query. If empty, the Crafts defaults will be used.

See [docs](https://craftcms.com/docs/4.x/entries.html#orderby)

## ownDraftsOnly 

* Type: `bool`
* Default: `false` 

If true and scope is defined: show only drafts created by the current user.

## query 

* Type: `ElementQuery`

Define your own query.

## scope 

* Type: `string` 

Whether drafts should be shown.

* drafts: Show 'regular' drafts
* provisional: Show 'provisional' drafts
* all: Show all drafts and all 'published' entries

If empty, only 'published' entries will be included.

## search 

* Type: `bool`
* Default: `false` 

Whether search will be enabled.

## section 

* Type: `array|string`

Craft section handle(s).

Will be passed to the section query, however if a `query` setting is set, it will only be used for default headings/permission checks.

## showIndexButton 

* Type: `bool`
* Default: `true` 

Whether button 'All entries' will be shown.

## showNewButton 

* Type: `bool`
* Default: `true`

Whether button 'New entry' will be shown.

## showRefreshButton 

* Type: `bool`
* Default: `true`

Whether to show a refresh button for this section.

## size 

string, the grid colum size of an entry for layouts card, cardlet. (tiny|small|medum|large|card)

## sortByScore 

bool, whether search results will be sorted by score. default=false

## status 

* Type: `string|array`

See [docs](https://craftcms.com/docs/4.x/entries.html#status)

If empty, all entries with all status (live, disabled, pending, expired) will be found.

## titleObjectTemplate 

* Type: `string`
* Default: `{title}` 

string, an object template that will be rendered for the title in a layout.