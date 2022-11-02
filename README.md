# Content Overview

Shows an overview of a site's content.

Work in progress...

## Config

Needs a config file in `config/contentoverview.php`

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