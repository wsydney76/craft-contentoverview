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
    'display' => 'widget',

    'layout' => [
        [
            'handle' => 'news',
            'limit' => 10,
            'info' => '{postDate|date("short")}',
            'image' => 'featuredImage'
        ],
        [
            'handle' => 'page',
            'info' => '{type.name}',
            'icon' => '@appicons/globe.svg'
        ],
        [
            'handle' => 'heroArea',
            'limit' => 10,
            'info' => '{postDate|date("short")}',
            'image' => 'featuredImage'
        ],
        [
            'handle' => 'legal',
            'info' => '{type.name}'
        ],
    ]
```