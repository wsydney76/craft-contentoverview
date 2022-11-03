# Content Overview

Shows an overview of a site's content.

Work in progress...

## Installation

Not yet on packagist.

Add to `composer.json`:

````json
{
  "minimum-stability": "dev",
  "prefer-stable": true,
  "repositories": [
     {
        "type": "vcs",
        "url": "https://github.com/wsydney76/craft-contentoverview"
     }
  ]
}

````

Run `composer require wsydney76/craft-contentoverview`

Run `craft plugin/install`

## Screenshots

Show different sections in different layouts (cards, cardlets, list). Add section specific infos and image.

![screenshot](/images/screenshot1.jpg)

Support your workflow and quality management: Show drafts / status / own provisional drafts

![screenshot](/images/screenshot2.jpg)

## Config

Setup a config file in `config/contentoverview.php`

Structure of the configuration file:


- navLabel (?string, label for primary navigation, page title)
- enableNav (?bool, default true, enable link item in primary navigation)
- enableWidgets (?bool, default true, enable dashboard widgets that display a single tab)
- widgetText (?string, text for dashboard link widget)
- linkTarget (?string, set to '_blank' to open edit screens in a new tab (default), else blank '')
- defaultLayout (?string, list (default)|cardlets|cards)
- transforms (?array, image transforms for layouts) 
- tabs[] (array, tabs of the page)
    - label (string, tab text)
    - id (string, unique id, used as anchor)
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

```php
<?php

return [

    'navLabel' => 'Content Dashboard',

    'tabs' => [
        [
            'label' => 'Site',
            'id' => 'tab1',

            // width: span in a 12 columns grid
            'columns' => [
                [
                    'width' => 7,
                    'sections' => [
                        [
                            'section' => 'news',
                            'heading' => 'Latest News',
                            'limit' => 6,
                            'info' => '{tagline}, {postDate|date("short")}',
                            'imageField' => 'featuredImage',
                            'layout' => 'cards'
                        ]
                    ]
                ],
                [
                    'width' => 5,
                    'sections' => [
                        [
                            'section' => 'heroArea',
                            'limit' => 2,
                            'info' => '{heroTagline}',
                            'imageField' => 'heroImage',
                            'layout' => 'cardlets'
                        ],
                        [
                            'section' => 'page',
                            'heading' => 'Page Structure',
                            'info' => '{isDraft ? "Draft"} {type.name}',
                            'icon' => '@appicons/globe.svg',
                            'scope' => 'all'
                        ]
                    ]
                ],
                [
                    'width' => 4,
                    'sections' => [
                        [
                            'section' => 'legal',
                            'info' => '{type.name}'
                        ]
                    ]
                ]
            ],
        ],
        [
            'label' => 'News',
            'id' => 'tab2',
            'columns' => [
                [
                    'width' => 6,
                    'sections' => [
                        [
                            'heading' => 'Drafts',
                            'section' => 'news',
                            'limit' => 12,
                            'info' => [
                                '{tagline}',
                                '{postDate|date("short")}',
                            ],
                            'popupInfo' => [
                                Craft::t('site', 'Draft created by') . ' {creator.name}',
                                Craft::t('site', 'Draft created at') . ' {draftCreatedAt|date("short")}',
                                '{draftNotes ? "Draft Notes:"}',
                                '{draftNotes}'
                            ],
                            'imageField' => 'featuredImage',
                            'layout' => 'cardlets',
                            'orderBy' => 'postDate desc',
                            'scope' => 'drafts',
                            'buttons' => false,
                        ],

                        [
                            'heading' => 'My Provisional Drafts',
                            'section' => 'news',
                            'limit' => 12,
                            'info' => '{tagline}, {postDate|date("short")}',
                            'imageField' => 'featuredImage',
                            'layout' => 'cardlets',
                            'orderBy' => 'postDate desc',
                            'scope' => 'provisional',
                            'ownDraftsOnly' => true,
                            'buttons' => false
                        ],
                        [
                            'heading' => 'Pending',
                            'section' => 'news',
                            'limit' => 12,
                            'info' => '{tagline}, {postDate|date("short")}',
                            'imageField' => 'featuredImage',
                            'layout' => 'cardlets',
                            'orderBy' => 'postDate desc',
                            'status' => 'pending',
                            'buttons' => false
                        ],
                        [
                            'heading' => 'Disabled',
                            'section' => 'news',
                            'limit' => 12,
                            'info' => '{tagline}, {postDate|date("short")}',
                            'imageField' => 'featuredImage',
                            'layout' => 'cardlets',
                            'orderBy' => 'postDate desc',
                            'status' => 'disabled',
                            'buttons' => false
                        ],

                    ]
                ],
                [
                    'width' => 6,
                    'sections' => [
                        [
                            'heading' => 'Latest Live News',
                            'section' => 'news',
                            'limit' => 12,
                            'info' => '{postDate|date("short")}',
                            'imageField' => 'featuredImage',
                            'layout' => 'list',
                            'orderBy' => 'postDate desc',
                            'status' => 'live'
                        ],

                    ]
                ]
            ]
        ]
    ]
];
```

## Events

Custom modules can extend the configuration by adding keys to the `sections` config array and modify the query via an
event:

```php
use wsydney76\contentoverview\events\ModifyContentOverviewQueryEvent;
use wsydney76\contentoverview\services\ContentOverviewService;


Event::on(
  ContentOverviewService::class,
  ContentOverviewService::EVENT_MODIFY_CONTENTOVERVIEW_QUERY,
  function(ModifyContentOverviewQueryEvent $event) {
  
    // Add selection criteria
    if (isset($event->sectionSettings['tagline'])) {
        $event->query->tagline($event->sectionSettings['tagline']);
    }
    
    // Add eager loading related elements that appear in info 
    $event->query->with(['assignedTo ...'])
  });
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