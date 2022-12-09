# Images and Icons

## Image

People are visual creatures, so images are important.

Which image will be displayed for an entry is determined in the following order in the `Section::getImage($entry))`
method:

* An image is defined via the `Section::EVENT_DEFINE_IMAGE` event. See example below.
* An image field is defined in the `imageField` section config setting, and at least one image is attached to that
  field.
* An image field is defined in the `fallbackImageField` section config setting, and at least one image is attached to
  that field.
* An image asset is defined in the `fallbackImage` plugin settings.

```php
'fallbackImage' => GlobalSet::find()->handle('siteInfo')->one()->featuredImage->one(),
```

Event example:

```php
use wsydney76\contentoverview\models\Section;
use wsydney76\contentoverview\events\DefineImageEvent;
...
Event::on(
    Section::class,
    Section::EVENT_DEFINE_IMAGE,
    function(DefineImageEvent $event) {
        /** @var Entry $entry */
        $entry = $event->entry;
        if ($entry->section->handle === 'film') {
            // TODO: improve performance, load/cache fallback images in advance
            $event->image = $entry->featuredImage->one() ??
                $entry->series->one()->featuredImage->one() ??
                GlobalSet::find()->handle('siteInfo')->one()->featuredImage->one() ??
                null;
        }
    }
);
```

## Icon

If there is no image, an icon is used.

Which icon will be displayed for an entry with which background color is determined in the following order in
the `Section::getIconData($entry))` method:

* An icon/background color is defined via the `Section::EVENT_DEFINE_ICON` event. See example below.
* An icon/background color is defined in the `icon`/`iconBgColor` section settings.
* A `defaultIcon` is defined in your `config\contentoverview.php` file.
* The `defaultIcon` that is defined in the main settings file `models\Settings.php`.

The icon is defined as a path to a svg image. Can contain an alias as in `@appicons/wand.svg`.

The background color is defined as anything than can be passed to the `background-image` css property.

Event example:

```php
// Section config
->icon('@appicons/newspaper.svg')
->iconBgColor('var(--blue-400')
```

```php
// Custom module
use wsydney76\contentoverview\models\Section;
use wsydney76\contentoverview\events\DefineIconEvent;
...
Event::on(
    Section::class,
    Section::EVENT_DEFINE_ICON,
    function(DefineIconEvent $event) {
        if ($event->entry->type->handle === 'privacy') {
            $event->icon = '@appicons/bullhorn.svg';
            $event->iconBgColor = 'var(--red-400)';
        }
    }
);
```

There is a `@coicons` alias that points the plugins own icon folder.

![Screenshot](/images/icons.jpg)