# Page Config

Setup config files in `config/contentoverview/<pagename>.php`.

If you are using a single page, name this page according to the `defaultPage` setting.

A page is always structured as follows:

A page

* has one or more tabs
*
    * which have one or more columns
*
    *
        * which have one or more sections

(The term 'section' is, admittedly, ambiguous. Here it means a part of a page, which in most cases, but not always,
displays entries from one Craft section.)

Structure of this file:

- tabs[] (array, tabs of the page)
    - label (string, tab label. Will not be visible if there is onyl one tab.)
    - columns[] (array, columns inside the tab container, uses a 12 columns grid)
        - width (int, number of columns occupied, 1-12)
        - sections[] (array, sections displayed inside the column)
            - [See Section Settings](./section-settings)

## Example

We use a 'fluid' config using tab/column/section models.

> All objects are created by the `ContentOverviewService` factory class. In this doc the variable `$doc` holds an instance of this class.

```php
// page1.php

<?php

use wsydney76\contentoverview\Plugin;

$co = Plugin::getInstance()->contentoverview;

return [
    'tabs' => [       
        $co->createTab('Site', require 'tab1.php'),
        $co->createTab('News', require 'tab2.php'),
        $co->createTab('News (Work)', require 'tab3.php'),
    ]
];

// tab3.php
<?php
/** @var wsydney76\contentoverview\services\ContentOverviewService $co */

use wsydney76\contentoverview\Plugin;

return [
    // Params: Column width (in a 12 columns grid), Section config
    $co->createColumn(12, [
        $co->createSection()
            ->section('news')
            ->heading('Drafts')
            ->limit(6)
            ->info('{tagline}, {postDate|date("short")}')
            ->imageField('featuredImage')
            ->layout('cardlets')
            ->scope('drafts')
            ->search(true),

        $co->createSection()
            ->section('news')
            ->heading('My Provisional Drafts')
            ->limit(6)
            // template has an `entry` variable available.
            // Using a regular template makes it easier to use more complex twig code like conditionals.
            ->infoTemplate('_cp/newsinfo.twig')
            ->imageField('featuredImage')
            ->layout('cardlets')
            ->scope('provisional')
            ->ownDraftsOnly(true),
       

```

Phpstorms autocompletion can give hints about the available settings and their parameters.

![screenshot](/images/autocomplete.jpg)

## Using custom query

Use 'query' to build individual queries that can't be composed with predefined parameters

Requires headings, disables Add new/List all buttons (can be any section).

```php
$co->createSection()
    ->heading('Custom Field')  
    ->section(['film','person','location'])         
    ->query(Craft::$app->user->identity->handpickedEntries)  // entries field           
    ->info('{postDate|datetime("short")}, {workflowStatus}')
])
```

If `query` is defined, a `section` param will only be used for permission checks, new/index button, default heading.

## Using defaults

You can pass default settings to the `createSection` method in order to avoid repetitions.

```php
$sectionDefaults = $co->createSection()
    ->imageField('featuredImage')
    ->orderBy('title')
    ->layout('cards')
    ->size('small')
    ->limit(6)
    ->search(true)
    ->info('{postDate|date("short")}')
    ->actions(['slideout']);

...

$co->createSection(config: $sectionDefaults)
    ->heading('Films')
    ->section('film')
    // Individual settings here

```

If you want to have defaults globally available, you can define them in your `config/contentoverview.php` file.

Note that you cannot use fluent config methods with autocomplete here, because the plugin is not yet initialized.

```php

'custom' => [
    'sectionDefault' => [
       'imageField' => 'featuredImage',
       'orderBy' => 'title',
       'layout' => 'cards',
       'size' => 'small',
       'limit' => 6,
       'search' => true,
       'info' =>  '{postDate|date("short")}',
        'actions' => ['slideout']
    ]
],
```

```php
$co->createSection(config: Plugin::getInstance()->getSettings()->custom['sectionConfig'])
```


You can also use a custom section class, this may be useful if your want to overwrite or add functionality.

See [Development -> Section](../dev/section#your-own-defaults) for details.

```php
$co->createSection(MySection::class)
    ->heading('Pending')
    ->status('pending'),
    
$co->createSection(MySection::class)
    ->heading('Drafts')
    ->scope('drafts')

```

## Extending section config

A custom section config class can also be useful to add custom query params. See [Development -> Section](../dev/section#your-own-settings) for details.

```php
->topic('sport')
```

## Dynamic Configuration

Configs can be created dynamically based on your content:

```php
return [
    'tabs' => Entry::find()
        ->section('topic')
        ->status(null)
        ->collect()
        ->map(function($entry) use ($co) {
            return $co->createTab($entry->title, [
               $co->createColumn(6, [
                   $co->createSection(NewsSection::class)
                        ->topic($entry)
               ])
            ]);
        })        
];
```
![Screenshot](/images/dynamicconfig.jpg)

## Reusing config objects

In case you find yourself duplicating config objects with minor modifications, the `ConfigHelper::require()` method comes to the rescue.

```php
use wsydney76\contentoverview\helpers\ConfigHelper;
...
 'tabs' => [
        ConfigHelper::require('tabs/tab_work', ['label' => 'News', 'section' => 'news']),
        ConfigHelper::require('tabs/tab_work', ['label' => 'Films', 'section' => 'film']),
        ConfigHelper::require('tabs/tab_work', ['label' => 'People', 'section' => 'person']),
        ConfigHelper::require('tabs/tab_work', ['label' => 'Locations', 'section' => 'location']),
    ]
```

```php
// tabs/tab_work.php

// A `params` variable is available

// Do not complain about missing variable, enable autocompletion
/** @var array{label: string, section: string|array} $params */

// Must return its data
return $co->createTab($params['label'], [
    ...
        $section($params['section'])
    ...
])

```

## Shortcuts

In case you have only one tab, one column, you can leave these levels out, a default object will be created behind the scenes.

```php
// pageconfig

// Only one tab
return [
    'columns' => [
        $co->createColumn(...),      
        $co->createColumn(...),      
    ]
];


// Only one tab, one column
return [
    'sections' => [
        $co->createSection(...),
        $co->createSection(...),
    ]       
];

// Only one column inside a tab
$co->createTab('Label')
    ->sections([
        $co->createSection(...),
        $co->createSection(...),
```

## Multi Section Setup

The section config usually uses a single Craft section, but can also be set to multiple Craft sections:

```php
->section(['film','person'])
```

Different sections and different entry types can use different field layouts, so you can take care of that by
providing an array to the `imageField`, `info`, `icon` and `infoTemplate` config settings like so:

```php
->info([
    'film' => '{series.one.title} {season}/{episode}',
    'person' => '{shortBio|truncate(20)}'
])

->imageField([
    '*' => 'featuredImage',
    'person.personExtended' => 'bigPortrait',
    'person' => 'thumbnail'
])
```

The image field is determined in the following sequence of keys:

* sectionHandle.typeHandle
* sectionHandle
* \* (default)