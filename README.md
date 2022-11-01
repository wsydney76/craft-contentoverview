# Content Overview

Shows an overview of a site's content.

Work in progress...

Needs a config file in `config/contentoverview.php`

Example:

```php
<?php

return [
    // Whether and where to show contentOverview
    // widget/nav/''
    'display' => 'nav',

    'layout' => [

        // width: number of columns in a 12 columns grid
        // handle: section handle
        // layout: list / cards / cardlets
        
        'columns' => [
            [
                'width' => 7,
                'sections' => [
                    [
                        'handle' => 'news',
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

    ]
];
```

![screenshot](/images/screenshot1.jpg)