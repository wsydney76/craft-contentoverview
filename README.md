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

## Screenshots

Show different sections in different layouts (cards, cardlets, list, line). Add section specific infos and image.

![screenshot](/images/screenshot1.jpg)

Support your workflow and quality management: Show drafts / status / own provisional drafts

![screenshot](/images/screenshot2.jpg)

## Plugin config

If you want to overwrite the settings from the plugins setting page, create a file `contentoverview.php` in your config folder.

- pluginTitle (?string, label for primary navigation, page title)
- enableNav (?bool, default true, enable link item in primary navigation)
- enableWidgets (?bool, default true, enable dashboard widgets that display a single tab)
- defaultPage (?string, page key for the first/only page.)
- widgetText (?string, text for dashboard link widget)
- linkTarget (?string, set to '_blank' to open edit screens in a new tab (default), else blank '')
- defaultLayout (?string, list (default)|cardlets|cards|line)
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
pages: an array of page configs in the form of [CP Sections Subnav](https://craftcms.com/docs/4.x/extend/cp-section.html#subnavs):
    
`'<pagename>' => ['label' => '<pageheading>', 'url' => 'contentoverview/<pagename>'],`

An additional param `group` can be added if this page should only be available for admins/members of this group.

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
            - section (string, section handle)
            - heading (?string, heading of the section, defaults to section name)
            - limit (?int, number of entries to show)
            - info (?string|array, object template(s) to render in addition to the title)
            - popupInfo (?string|array, object template(s) to render in an information popup)
            - imageField (?string, name of the image field to use)
            - layout (?string, (list (default)|cardlets|cards|line)
            - scope (?string, whether drafts should be shown, drafts|provisional|all, default: only published entries will be included)
            - ownDraftsOnly (?bool, if true and scope is defined: show only drafts created by the current user)
            - status (?string|array, see [docs](https://craftcms.com/docs/4.x/entries.html#status)
            - allSites (?bool, true = display (unique) entries from all sites)
            - orderBy (?string|array see [docs](https://craftcms.com/docs/4.x/entries.html#orderby)
            - buttons (?bool whether buttion 'new entry', 'all entries' will be shown
            - custom  (?array, any custom keys, can be used to modify the entries query via event, see below)
       

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
* Some inline comments are missing...