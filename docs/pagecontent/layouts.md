# Layouts

Entries can be shown in different layouts.

List and line layouts can show indentations for different levels in a structure.

## Cards

A vertical layout that puts emphasis on an image and allows unlimited multi line content.

![Layout Cards](/images/layout_cards.jpg)

### Size and image aspect ratio

The visual impression of a card is highly depending on the type of image and the content/actions (e.g. typical length of
title) in it.

So you may want to change the grid column width and the aspect ratio of the image for a better experience.

For example, for a person directory a smaller width and a portrait mode will be better:

```php
->size('tiny')
->imageRatio(4/5)
```

![Screenshot](/images/tinysection.jpg)

## Cardlets

A more compact layout, less space for info

![Layout Cardlets](/images/layout_cardlets.jpg)

A size section config setting can be applied.

## List

Horizontal layout, keep info on one line!

![Layout List](/images/layout_list.jpg)

## Line

Horizontal layout without image. The most compact layout.

![Layout Line](/images/layout_line.jpg)

Do not specify an `imageField` for this layout.

## Table

A table with multiple columns.

![Screenshot](/images/tablelayout.jpg)

```php
$co->createTableSection('News', [
    $co->createTableColumn()
        ->label('Tagline')
        ->value('{tagline}'),
    $co->createTableColumn()
        ->label('PostDate')
        ->value('{postDate|date("short")}'),
    $co->createTableColumn()
        ->label('Workflow')
        ->template('_contentoverview/columns/workflow.twig')
])
    ->section('news')
    // all section config settings are available here
```

Available settings:

- TableSection
    - showImage (bool, whether to show the image column)
    - showStatus (bool, whether to show the status column)
    - showTitle (bool, whether to show the title column)
    - columns[] (array of TableColumns models)
        - label (string, column heading)
        - value (string, an object template) or:
        - template (string, a custom twig template, an `entry` variable will be available)
        - align (string, left (default)|right, alignment of the column content)

A `TableSection::EVENT_DEFINE_TABLECOLUMNS` event is available if you want to taylor the columns.