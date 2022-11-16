# Content Overview

This plugin shows configurable overviews of a site's content.

## Disclaimer

* This plugin is developed as a side/training project for internal use only.
* It works for us, but may not work everywhere.
* There may be (well, is) an unlimited amount of
    * bugs
    * rough edges (the CSS is a mess...)
    * incompatibilities
    * lack of professional standards
    * lack of documentation/inline comments
    * missing features
    * bad performance
    * bad English.
* Developed for Craft 4.3, but not guaranteed to survive any updates.
* Supports only entries element type.
* **We are not able to offer any support.**
* Feel free to use it/fork it/adopt it/do whatever you want with it.

## Installation

Run `composer require wsydney76/craft-contentoverview`

Run `craft plugin/install contentoverview`

This is currently work in progress, set your `composer.json` requirement to `"wsydney76/craft-contentoverview": "dev-main"`
and run `composer update` to get the latest stuff.

## Screenshots

Show different sections in different layouts (cards, cardlets, list, line). Add section specific infos and image.
Search and pagination is supported.

![screenshot](/images/screenshot1.jpg)

Support your workflow and quality management: Show drafts / status / own provisional drafts

![screenshot](/images/screenshot2.jpg)

## Plugin config

Create a file `contentoverview.php` in your config folder.

- pluginTitle (?string, label for primary navigation, page title)
- enableNav (?bool, default true, enable link item in primary navigation)
- enableWidgets (?bool, default true, enable dashboard widgets that display a single tab)
- defaultPage (?string, page key for the first/only page.)
- widgetText (?string, text for dashboard link widget)
- linkTarget (?string, set to '_blank' to open edit screens in a new tab (default), else blank '')
- enableSlideoutEditor (?bool, whether a slideout editor can be opened for an entry by a double click on the status indicator, or by clicking an icon. Experimental)
- defaultLayout (?string, list (default)|cardlets|cards|line)
- customTemplatePath (?string, folder for custom templates, default = contentoverview)
- defaultIcon (?string, file path to a svg icon, default = @appicons/newspaper.svg)
- transforms (?array, image transforms for layouts)
- pages (!array, defines subpages)

```php
<?php

return [
    'enableNav' => false
];
```

### Single Page Setup

By default, a link to a single page is added to the navigation sidebar.

![screenshot](/images/nav1.jpg)

This requires a setup up file named after the `defaultPage` settings.

### Multi Page Setup

You can configure multiple pages by adding them to the `config/contenoverview.php` file.

![screenshot](/images/nav2.jpg)

```php
<?php

return [
    'defaultPage' => 'page1',
    'pages' => [
        'page1' => ['label' => 'Site/News', 'url' => 'contentoverview/page1'],
        'page2' => ['label' => 'In Progress', 'url' => 'contentoverview/page2', 'group' => 'reviewers'],
    ]
];
```

defaultPage: the page that is initially selected. Usually the first one.
pages: an array of page configs in the form
of [CP Sections Subnav](https://craftcms.com/docs/4.x/extend/cp-section.html#subnavs):

`'<pagename>' => ['label' => '<pageheading>', 'url' => 'contentoverview/<pagename>'],`

An additional param `group` can be added if this page should only be available for admins/members of this group.

A param `blocks` can define custom templates that are rendered in a cp panel block, see 'Templates' below.

### Widgets

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

## Page Config

Setup config files in `config/contentoverview/<pagename>.php`.

If you are using a single page, name this page according to the `defaultPage` setting.

Structure of this file:

- tabs[] (array, tabs of the page)
    - label (string, tab text)
    - columns[] (array, columns inside the tab container, uses a 12 columns grid)
        - width (int, number of columns occupied, 1-12)
        - sections[] (array, sections display inside the column)
            - section (array|string, section handle)
            - heading (?string, heading of the section, defaults to section name)
            - limit (?int, number of entries to show)
            - info (?string|array, object template to render in addition to the title)
            - popupInfo (?string, object template to render in an information popup)
            - infoTemplate (?array|string, path to a twig template inside the projects templates folder. Will be called with
              an entries variable)
            - imageField (?array|string, name of the image field to use)
            - icon (?array|string, path to an svg icon, that is display if no image is found)
            - layout (?string, (list (default)|cardlets|cards|line)
            - scope (?string, whether drafts should be shown, drafts|provisional|all, default: only published entries
              will be included)
            - ownDraftsOnly (?bool, if true and scope is defined: show only drafts created by the current user)
            - status (?string|array, see [docs](https://craftcms.com/docs/4.x/entries.html#status)
            - allSites (?bool, true = display (unique) entries from all sites)
            - orderBy (?string|array see [docs](https://craftcms.com/docs/4.x/entries.html#orderby)
            - buttons (?bool whether buttion 'new entry', 'all entries' will be shown
            - linkToPage (?string, the key of a page the heading is linked to. May contain an anchor, e.g. `page1#tab1`)
            - search (?bool, whether search will be enabled)
            - sortByScore (?bool, whether search results will be sorted by score. default=false)
            - filters (?array, Array of fields whose values can be applied as filters. See Search doc below)
            - custom  (?array, any custom keys, can be used to modify the entries query via event, see Events below)

Example:

We use a 'fluid' config using tab/column/section models.

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
        
        // Optinal param: Class name of a class extending wsydney76\contentoverview\models\Section,
        // where you can set defaults to avoid repeating yourself.      
        $co->createSection(NewsSection::class)
            ->heading('Pending')
            ->status('pending'),
            
        $co->createSection(NewsSection::class)
            ->heading('Drafts')
            ->scope('drafts')
            ->popupInfo( Craft::t('site', 'Draft created by') . ' {creator.name}' . '<br>' .
                    Craft::t('site', 'Draft created at') . ' {draftCreatedAt|date("short")}' . '<br>' .
                    '{draftNotes ? "Draft Notes:"}' . '<br>' .
                    '{draftNotes}'),
                    ])

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

Phpstorms autocompletion can give hints about the available settings and their parameters.

![screenshot](/images/autocomplete.jpg)

## Multi Section Setup

The section config usually uses a single section, but can also be set to multiple sections:

```php
->section(['film','person'])
```

Different sections and different entry types can use different field layouts, so you can take care of that by
providing an array to the `imageField`, `info`, `popupInfo`, `icon` and `infoTemplate` config settings like so:

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

## Layouts

Entries can be shown in different layouts.

List and line layouts can show indentations for different levels in a structure.

### Cards

A vertical layout that allows unlimited multi line content.

![Layout Cards](/images/layout_cards.jpg)

### Cardlets

A more compact layout, less space for info

![Layout Cardlets](/images/layout_cardlets.jpg)

### List

Horizontal layout, keep info on one line!

![Layout List](/images/layout_list.jpg)

### Line

Horizontal layout without image. The most compact layout.

![Layout Line](/images/layout_line.jpg)

Do not specify a `imageField` for this layout.

## Searching

Add searching to a section by setting the `search` attribute to true:

```php
->search(true)
```

![Screenshot](/images/search1.jpg)

The search will be executed respecting `defaultSearchTermOptions` in your general settings.

### Search attributes

A search can be narrowed down by adding a prefix that defines a field to search in, like `title:whatsoever`.

You can add a `searchAttributes` section config setting to make that easier for your user.

```php
->searchAttributes([
    ['label' => 'Title', 'value' =>  'title'],
    ['label' => 'Body Content', 'value' =>  'bodyContent'],
])
```

This will add a dropdown:

![Screenshot](/images/search2.jpg)

The prefix will be automatically added to the search query.

## Filters

Entries can be filtered by a custom field value.

```php
->filters([
    ['field' => 'topics'],
    ['field' => 'assignedTo', 'orderBy' => 'lastName, firstName', 'label' => 'Responsible'],
    ['field' => 'workflowStatus'],
])
```

Currently supported:

* Entries fields
* Users fields
* Option fields (Dropdown)

![Screenshot](/images/search3.jpg)

Additionally custom filters can be defined:

```php
->filters([
    [
        'type' => 'custom',
        'label' => 'Critical reviews...',
        'field' => 'criticalreviews', // a pseudo field name, handled in event
        'options' => [
            ['label' => 'Overdue', 'value' => 'overdue'],
            ['label' => 'Next week', 'value' => 'nextweek'],
        ]
    ],
])
```

![Screenshot](/images/customfilter.jpg)

Options can be set dynamically via an event:

```php
use wsydney76\contentoverview\events\DefineCustomFilterOptionsEvent;
use wsydney76\contentoverview\models\Section;

...

Event::on(
    Section::class,
    Section::EVENT_DEFINE_CUSTOM_FILTER_OPTIONS,
    function(DefineCustomFilterOptionsEvent $event) {
        if ($event->filter['field'] === 'criticalreviews') {
            $event->filter['options'][] = [
              'label' => 'A new option',
              'value' => 'aNewOption'
            ];
        }
    }
);
```

A custom module can handle this filter in an event handler, e.g.

```php

use wsydney76\contentoverview\events\FilterContentOverviewQueryEvent;
use wsydney76\contentoverview\models\Section;

...

Event::on(
    Section::class,
    Section::EVENT_FILTER_CONTENTOVERVIEW_QUERY,
    function(FilterContentOverviewQueryEvent $event) {
        $filter = $event->filter;
        if ($filter['field'] === 'criticalreviews') {
            switch ($filter['value']) {
                case 'overdue':
                {
                    $event->query
                        ->workflowStatus('inReview')
                        ->dueDate('<' . DateTimeHelper::today()->format('Y-m-d'));
                    break;
                }
                case 'nextweek':
                {
                    $event->query
                        ->workflowStatus('inReview')
                        ->dueDate([
                            'and',
                            '>' . DateTimeHelper::today()->format('Y-m-d'),
                            '<' . DateTimeHelper::nextWeek()->format('Y-m-d'),
                        ]);
                    break;
                }
            }
        }
    }
);
```

Multiple filters can take up a lot of space if used together with search, so you can push them
below or on top of the search:

```php
->filtersPosition('bottom') // top|bottom
```

Highly experimental:

Matrix subfields can also be used as filters:

```php
 ['field' => 'streaming.streamingProvider', 'orderBy' => 'title']
 ['field' => 'media.digitalMedium.storageLocation', 'orderBy' => 'title'],                        
```

Specify fields in the form `matrixFieldHandle.blockTypeHandle.subFieldHandle`.

If there is only one block type, you can use `matrixFieldHandle.subFieldHandle`

## Templates

All twig templates are called like so:

```php
{% include [
    '_contentoverview/partials/entry.twig',
    'contentoverview/partials/entry.twig'
] %}
```
where the template root  `_contentoverview` by default points to your project's `templates/_contentoverview` folder.

This allows you to overwrite any twig template in case you have special needs.

Templates are included without an `only` parameter, because we know what our templates need, but maybe you need more in your templates.
Required params passed to a template are listed in an `@params` comment.

Generally available variables:

* settings - The plugin settings
* page - The page object

Variables available within a section:

* sectionConfig - The section object containing all section settings
* sectionPath - A unique identifier of a section, enables ajax request to identify the section
* sectionPageNo - The current page shown in the section
* tab - the current tab object
* column - the current column object

Entry template and includes

* entry - You guessed it.

### Custom Sections

You can create a custom section, where a custom template will be rendered.

```php
$co->createCustomSection()
    ->heading('Create Screening')
    ->customTemplate('custom/create_screening.twig')
```

Your template must live in the `settings.customTemplatePath` folder, by default `templates/_contentoverview`.

Nothing special on the part of the plugin, but it opens amazing possibilities
to provide custom solutions for editors, whose work can thus be considerably facilitated.

See example below:

### Blocks

[Control panel templates](https://craftcms.com/docs/4.x/extend/cp-templates.html#available-blocks) make 
a number of twig `{% block %}` areas available, where custom templates can be rendered.

This can be helpful if you want to add instructions/help/guides/link lists/whatever to your page 
in order to support editors.

Your template must live in the `settings.customTemplatePath` folder, by default `templates/_contentoverview`

```php
'pages' => [
    'page1' => ['label' => 'Site/News', 'url' => 'contentoverview/page1', 'blocks' => [
        'details' => 'blocks/co_page1_guide.twig',      
    ]],
    'page2' => ['label' => 'In Progress', 'url' => 'contentoverview/page2', 'group' => 'reviewers'],
]
```

Available blocks:

* sidebar
* details - wrap content in `<div class="meta" style="padding: 12px;">  </div>`
* toolbar
* footer

The `page` and `settings` variable are availabe in this templates.

Example: 

```twig
<div class="meta" style="padding: 12px;">
    <h2>Guide for {{ page.label }}</h2>
    <p>
        Nullam vel sem. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Vivamus quis mi. Nunc nonummy metus. Vivamus euismod mauris.
    </p>
    <p>
        Aenean posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin urna dolor sagittis lacus. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Vestibulum eu odio. Fusce risus nisl, viverra et, tempor et, pretium in, sapien.
    </p>

    {% set entries = craft.entries
        .section('editorNews')
        .site(craft.app.request.queryParam('site'))
        .limit(5).all %}
    {% for entry in entries %}
    	<h3>{{ entry.title }}</h3>
        <p>
            {{ entry.body|md|purify }}
        </p>
    {% endfor %}
</div>
```

### Customization Example

Managing screenings for a film festival:

![Screenshot](/images/customize-example.jpg)

* Guide with project specific help
* Easy filtering with fewer clicks
* Add new screenings without loading new pages. Especially useful when there is a lot of repetition. Just change date/time, click 'Create', done.

## Events

Custom modules can extend the configuration by adding keys to the `sections` config array and modify the query via an
event:

```php
use wsydney76\contentoverview\events\ModifyContentOverviewQueryEvent;
use wsydney76\contentoverview\models\Section;


Event::on(
    Section::class,
    Section::EVENT_MODIFY_CONTENTOVERVIEW_QUERY,
    function(ModifyContentOverviewQueryEvent $event) {
        /** @var Section $sectionConfig */
        $sectionConfig = $event->sender;
        if (isset($sectionConfig->custom['tagline'])) {
            $event->query->tagline($sectionConfig->custom['tagline']);
        }
        
        // Add eager loading related elements that appear in info 
        $event->query->with(['assignedTo ...'])
    }
);
```

See also 'Filters'.

## Link Widget

There is a small dashboard widget, offering quick links to each tab of the overview page.

![screenshot](/images/widget.jpg)

## Tab Widget

A single tab can be shown in a dashboad widget.

Select a tab to show and set the widget width to Full (full width), if you want to spread the widget over all dashboard
columns,
otherwise to Two (half width) in order to use it with two or three columns.

One column is too narrow to be useful.

![screenshot](/images/widgetsettings.jpg)

## TODOS:

* Improve responsive styles
* Check permission handling
* Some translations are missing...
* Some inline comments are missing...
* Accessibility...