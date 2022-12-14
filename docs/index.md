# Content Overview

This Craft CMS plugin shows configurable overviews of a site content.

::: info Latest version
Latest tagged version: 5.4. Beta quality.
:::

## Disclaimer

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

## Updates

This is no 'official' Craft plugin, so Craft will not detect updates. Check this page for updates.

Make sure your `composer.json` file points to the latest version or `dev-main` for unreleased updates.

```json
{
  "require": {
    "wsydney76/craft-contentoverview": "^5.0.0"
  }
}
```

Run `composer update`.


## Quick Start

Create a file `config/contentoverview/default.php` with this content:

```php
<?php

use wsydney76\contentoverview\Plugin;

$co = Plugin::getInstance()->contentoverview;

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

[![screenshot](/screenshot1.jpg)](/craft-contentoverview/screenshot1.jpg)


Support your workflow and quality management: Show drafts / status / own provisional drafts

[![screenshot](/screenshot2.jpg)](/craft-contentoverview/screenshot2.jpg)

## Known issues

* Undocumented things from Craft 4.3 core are used: css classes, css variables, scripts, icons... This may break
  anytime.
* Invalid config settings/no proper checks in custom modules may crash the Control Panel.

## Did not make it into final version

* Optionally show actions in dropdown
* Dynamic pages
* 'Deep merge' of config objects
* Configurable integrations

## TODOS

* Tests...
* Improve styles
* Improve error handling
* Check permission handling
* Some translations are missing...
* Some inline comments are missing...
* Check accessibility...
* Check this doc for accuracy and  completeness
* Run code through code checkers.

## Finally

This plugin gives a lot of different options, trying to hide complexity from devs/users.

However: The simplest way is always the best. KISS!