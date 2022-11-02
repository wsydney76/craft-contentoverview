# Content Overview

Shows an overview of a site's content.

Work in progress...

## Config

Needs a config file in `config/contentoverview.php`

Structure of the configuration file:


- navLabel (string, label for primary navigation, page title)
- widgetText (string, text for dashboard widget)
- linkTarget (string, set to '_blank' to open edit screens in a new tab (default), else blank '')
- tabs[] (array, tabs of the page)
    - label (string, tab text)
    - id (string, unique id, used as anchor)
    - columns[] (array, columns inside the tab container, uses a 12 columns grid)
        - width (int, number of columns occupied, 1-12)
        - sections[] (array, sections display inside the column)
            - handle (string, section handle)
            - heading (string, optional, heading of the section, defaults to section name)
            - limit (int, optional, number of entries to show)
            - info (string|array, object template(s) to render in addition to the title)
            - image (string, optional, name of the image field to use)
            - layout (string, optional, (list (default)|cardlets|cards)
            - scope (string, optional, whether drafts should be shown, drafts|provisional|provisionaluser|all, default: only published entries will be included)
            - status (string|array, optional, see [docs](https://craftcms.com/docs/4.x/entries.html#status)
            - orderBy (string|array, optional see [docs](https://craftcms.com/docs/4.x/entries.html#orderby)
            - buttons (bool, optional whether buttion 'new entry', 'all entries' will be shown
       


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
                            'handle' => 'news',
                            'heading' => 'Latest News',
                            'limit' => 6,
                            'info' => '{tagline}, {postDate|date("short")}',
                            'image' => 'featuredImage',
                            'layout' => 'cards'
                        ]
                    ]
                ],
                [
                    'width' => 5,
                    'sections' => [
                        [
                            'handle' => 'heroArea',
                            'limit' => 2,
                            'info' => '{heroTagline}',
                            'image' => 'heroImage',
                            'layout' => 'cardlets'
                        ],
                        [
                            'handle' => 'page',
                            'heading' => 'Page Structure',
                            'info' => '{type.name}',
                            'icon' => '@appicons/globe.svg'
                        ]
                    ]
                ],
                [
                    'width' => 4,
                    'sections' => [
                        [
                            'handle' => 'legal',
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
                    'width' => 5,
                    'sections' => [
                        [
                            'heading' => 'Drafts',
                            'handle' => 'news',
                            'limit' => 12,
                            'info' => '{tagline}, {postDate|date("short")}',
                            'image' => 'featuredImage',
                            'layout' => 'cardlets',
                            'orderBy' => 'postDate desc',
                            'scope' => 'drafts',
                            'buttons' => true,
                        ],

                        [
                            'heading' => 'My Provisional Drafts',
                            'handle' => 'news',
                            'limit' => 12,
                            'info' => '{tagline}, {postDate|date("short")}',
                            'image' => 'featuredImage',
                            'layout' => 'cardlets',
                            'orderBy' => 'postDate desc',
                            'scope' => 'provisional',
                            'buttons' => false
                        ],
                        [
                            'heading' => 'Pending',
                            'handle' => 'news',
                            'limit' => 12,
                            'info' => '{tagline}, {postDate|date("short")}',
                            'image' => 'featuredImage',
                            'layout' => 'cardlets',
                            'orderBy' => 'postDate desc',
                            'status' => 'pending',
                            'buttons' => false
                        ],
                        [
                            'heading' => 'Disabled',
                            'handle' => 'news',
                            'limit' => 12,
                            'info' => '{tagline}, {postDate|date("short")}',
                            'image' => 'featuredImage',
                            'layout' => 'cardlets',
                            'orderBy' => 'postDate desc',
                            'status' => 'disabled',
                            'buttons' => false
                        ],

                    ]
                ],
                [
                    'width' => 7,
                    'sections' => [
                        [
                            'heading' => 'Latest Live News',
                            'handle' => 'news',
                            'limit' => 12,
                            'info' => '{postDate|date("short")}',
                            'image' => 'featuredImage',
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

![screenshot](/images/screenshot1.jpg)

![screenshot](/images/screenshot2.jpg)

## TODOS:

* Improve responsive styles
* Permissions...