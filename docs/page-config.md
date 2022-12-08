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
            - actions (array, The actions available to the section. See below)
            - allSites (bool, true = display (unique) entries from all sites.)
            - custom  (array, any custom data, can be used in custom events/classes/templates)
            - entryType (array|string, entryType handle)
            - fallbackImageField (array|string, name of an image field to use if there is no image set in `imageField`.)
            - filters (array, Array of fields whose values can be applied as filters. See Filters chapter below.)
            - heading (string, heading of the section, defaults to section name.)
            - help (array|string Help text for the section. See Help chapter below.)
            - icon (array|string, path to a svg icon that will be displayed if no image is found)
            - iconBgColor (string, the background color for an icon.)
            - imageField (array|string, name of the image field to use.)
            - imageRatio (float, aspect ratio of the image. Only makes sense for card layout.)
            - info (string|array, object template to render in addition to the title.)
            - infoTemplate (array|string, path to a twig template inside the projects templates folder. Will be called with an entries variable.)
            - layout (string, the layout used to display entries. (list (default)|cardlets|cards|line|table)
            - limit (int, number of entries to show on one section page. Default to 9999.)
            - linkToPage (string, the key of a page the heading is linked to. May contain an anchor, e.g. `page1#tab1`.)
            - orderBy (string|array see [docs](https://craftcms.com/docs/4.x/entries.html#orderby)
            - ownDraftsOnly (bool, if true and scope is defined: show only drafts created by the current user.)
            - query (ElementQuery, define your own query.)
            - scope (string, whether drafts should be shown, drafts|provisional|all, default: only published entries will be included.)
            - search (bool, whether search will be enabled.)
            - section (array|string, Craft section handle.)
            - showIndexButton (bool whether button 'All entries' will be shown.)
            - showNewButton (bool whether button 'New entry' will be shown.)
            - showRefreshButton (bool, whether to show a refresh button for this section.)
            - size (string, the grid colum size of an entry (for layouts card, cardlet). tiny|small|medum|large|card)
            - sortByScore (bool, whether search results will be sorted by score. default=false)
            - status (string|array, see [docs](https://craftcms.com/docs/4.x/entries.html#status)
            - titleObjectTemplate (string, an object template that will be rendered for the title in a layout. Defaults to, well, `{title}`)

## Common settings

The following settings can be applied to every object (page/tab/column/section/filter/action...)

* handle (string, a handle that helps to identify the object in events/custom templates.)
* custom  (array, can contain any data that you want to use in events/custom templates).
* permission (string, only admins and users with this permission will see this object.)
* group (string|array, only admins and members of this group/one of these groups will see this object. Will be ignored if the more specific `permission` is set)



## Example

We use a 'fluid' config using tab/column/section models.

> All objects are created by the `ContentOverviewService` factory class. In this doc the variable `$doc` holds an instance of this class.

```php
// page1.php

<?php

use wsydney76\contentoverview\services\ContentOverviewService;

$co = new ContentOverviewService();

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

use wsydney76\contentoverview\services\ContentOverviewService;

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

```php
$co->createSection(NewsSection::class)
    ->heading('Pending')
    ->status('pending'),
    
$co->createSection(NewsSection::class)
    ->heading('Drafts')
    ->scope('drafts')
    
// modules/main/NewsSection.php

<?php

namespace modules\main;

use wsydney76\contentoverview\models\Section;

class NewsSection extends Section
{
    public array|string $section = 'news';
    public ?int $limit = 12;
    public array|string $imageField = 'featuredImage';
    public string $layout = 'cardlets';
    public bool $buttons = false;
    public array|string $info = '{tagline}, {postDate|date("short")}';
}

];
```

## Extending section config

A custom section config class can also be useful to add custom query params:

```php
// Config:
->topic('sport')

// Section class
...
class NewsSection extends Section
{
    ... defaults as above
    public mixed $topic = null; // your new setting

    // Setter method for fluent config, accepts either a string or anything that can be passed to `relatedTo`.
    public function topic(mixed $topic): self
    {
        $this->topic = $topic;
        return $this;
    }

    // Add query param
    public function getQuery(array $params): ElementQueryInterface
    {
        $query = parent::getQuery($params);

        if ($this->topic) {
            if (is_string($this->topic)) {
                $this->topic = Entry::find()->section('topic')->slug($this->topic)->ids();
            }
            if ($this->topic) {
                $query->andRelatedTo(['targetElement' => $this->topic, 'field' => 'topics'] );
            }
        }

        return $query;
    }
}
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