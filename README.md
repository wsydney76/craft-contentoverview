# Content Overview

Shows an overview of a site's content.

Work in progress...

## Installation

Run `composer require wsydney76/craft-contentoverview`

Run `craft plugin/install`

## Screenshots

Show different sections in different layouts (cards, cardlets, list). Add section specific infos and image.

![screenshot](/images/screenshot1.jpg)

Support your workflow and quality management: Show drafts / status / own provisional drafts

![screenshot](/images/screenshot2.jpg)

## Plugin config

If you want to overwrite the settings from the plugins setting page, create a file `contentoverview.php` in your config folder.

- pluginTitle (?string, label for primary navigation, page title)
- enableNav (?bool, default true, enable link item in primary navigation)
- enableWidgets (?bool, default true, enable dashboard widgets that display a single tab)
- widgetText (?string, text for dashboard link widget)
- linkTarget (?string, set to '_blank' to open edit screens in a new tab (default), else blank '')
- defaultLayout (?string, list (default)|cardlets|cards)
- transforms (?array, image transforms for layouts)

```php
<?php

return [
    'enableNav' => false
];
```

## Tab Config

Setup a config file in `config/contentoverview_tabs.php`

Structure of this file:

- tabs[] (array, tabs of the page)
    - label (string, tab text) 
    - columns[] (array, columns inside the tab container, uses a 12 columns grid)
        - width (int, number of columns occupied, 1-12)
        - sections[] (array, sections display inside the column)
            - section (string, section handle)
            - heading (?string, heading of the section, defaults to section name)
            - limit (?int, number of entries to show)
            - info (?string|array, object template(s) to render in addition to the title)
            - popupInfo (?string|array, object template(s) to render in an information popup)
            - imageField (?string, name of the image field to use)
            - layout (?string, (list (default)|cardlets|cards)
            - scope (?string, whether drafts should be shown, drafts|provisional|provisionaluser|all, default: only published entries will be included)
            - ownDraftsOnly (?bool, if true and scope is defined: show only drafts created by the current user)
            - status (?string|array, see [docs](https://craftcms.com/docs/4.x/entries.html#status)
            - allSites (?bool, true = display (unique) entries from all sites)
            - orderBy (?string|array see [docs](https://craftcms.com/docs/4.x/entries.html#orderby)
            - buttons (?bool whether buttion 'new entry', 'all entries' will be shown
            - any custom keys (?mixed, can be used to modify the entries query via event, see below)
       

Example:

We use a 'fluid' config using tab/column/section models.

```php
// contentoverview_tabs.php

<?php

use wsydney76\contentoverview\services\ContentOverviewService;

$co = new ContentOverviewService();

return [

    'navLabel' => 'Content Dashboard',

    'tabs' => [
        // Params: Tab label, Tab Id (anchor), Tab Config (in separate files here for better readability), Scope (all (default)|page|widget)
        $co->createTab('Site', 'tab1', require 'contentoverview/tab1.php'),
        $co->createTab('News', 'tab2', require 'contentoverview/tab2.php', 'page'),
        $co->createTab('News (Work)', 'tab3', require 'contentoverview/tab3.php', 'widget'),
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
            ->scope('drafts'),

        $co->createSection()
            ->section('news')
            ->heading('My Provisional Drafts')
            ->limit(6)
            ->info('{tagline}, {postDate|date("short")}')
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
            ->popupInfo([
                Craft::t('site', 'Draft created by') . ' {creator.name}',
                Craft::t('site', 'Draft created at') . ' {draftCreatedAt|date("short")}',
                '{draftNotes ? "Draft Notes:"}',
                '{draftNotes}'
            ]),
    ])

// modules/main/NewsSection.php

<?php

namespace modules\main;

use wsydney76\contentoverview\models\Section;

class NewsSection extends Section
{
    public array|string $section = 'news';
    public ?int $limit = 12;
    public ?string $imageField = 'featuredImage';
    public string $layout = 'cardlets';
    public bool $buttons = false;
    public array|string $info = '{tagline}, {postDate|date("short")}';
}

];


```

Phpstorms autocompletion can give hints about the available settings and their parameters.

![screenshot](/images/autocomplete.jpg)

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

## Link Widget

There is a small dashboard widget, offering quick links to each tab of the overview page.

![screenshot](/images/widget.jpg)

## Tab Widget

A single tab can be shown in a dashboad widget.

Select a tab to show and set the widget width to Full (full width), if you want to spread the widget over all dashboard columns,
otherwise to Two (half width) in order to use it with two or three columns. 

One column is too narrow to be useful. 

![screenshot](/images/widgetsettings.jpg)

## TODOS:

* Improve responsive styles
* Check permission handling
* Some translations are missing...