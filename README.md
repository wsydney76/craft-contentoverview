# Content Overview

This plugin shows configurable overviews of a site's content.

## Documentation

Detailed docs are available at [https://wsydney76.github.io/craft-contentoverview/](https://wsydney76.github.io/craft-contentoverview/).

## Disclaimer

Another final evaluation/test version (5.1).

> On request, we moved the configuration of subpages from general plugin config to a dedictated file with fluent config.
> 
> See upgrading from 4.x in the Changelog.

* This plugin was initially developed as a side/training project for internal use only.
* Added a bunch of customization options when evaluating it in a real-life project.
* It works for us, but may not work everywhere.
* There still may be (well, are) some
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


## Requirements

This plugin requires Craft CMS 4.3 or later.

## Installation

Run `composer require wsydney76/craft-contentoverview`

Run `craft plugin/install contentoverview`

## Quick Start

Create a file `config/contentoverview/default.php` with this content:

```php
<?php

use wsydney76\contentoverview\services\ContentOverviewService;

$co = new ContentOverviewService();

return [
    'tabs' => [
        $co->createTab('Site', [
            $co->createColumn(8, [
                $co->createSection()
                    ->section('news')
                    ->layout('cards')
                    ->imageField('featuredImage')
                    ->size('small')
                    ->info('{author.name}, {postDate|date("short")}')
                    ->limit(12)
            ]),
            $co->createColumn(4, [
                $co->createSection()
                    ->section('page')
            ])
        ]),

    ]
];
```

Replace `news/page` with one or your section handles (a channel/a structure). Replace `featuredImage` with an asset fields handle. 

## Screenshots

Show different sections in different layouts (cards, cardlets, list, line). Add section specific infos and image.
Search, filtering and pagination is supported.


![screenshot](/docs/public/screenshot1.jpg)

Support your workflow and quality management: Show drafts / status / own provisional drafts

![screenshot](/docs/public/screenshot2.jpg)
