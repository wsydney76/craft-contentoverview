# Plugin config

Create a file `contentoverview.php` in your config folder. See [docs](https://craftcms.com/docs/4.x/extend/plugin-settings.html#overriding-setting-values).

Settings in alphabetical order:

- altTemplate (string, object template used to render the alt attribute of images, defaults to `{alt}`)
- custom (array, can contain any data you want to use somewhere in your setup.)
- customTemplatePath (string, folder for custom templates, defaults to _contentoverview)
- defaultIcon (string, file path to a svg icon, defaults to @coicons/newspaper.svg)
- defaultLayout (string, the layout that is used by default. list (default)|cardlets|cards|line)
- defaultPage (string, page key for the first/only page. Defaults to 'default'.)
- enableCreateInSlideoutEditor (bool, whether new entries will be created in a slideout editor. Defaults to false on multi-site installs, else true. Experimental)
- enableSlideoutEditor (bool, whether a slideout editor can be opened for an entry by a double click on the status indicator, or by clicking an icon/image. Experimental)
- extraPermissions (array, adds permissions)
- enableWidgets (bool, default true, enable dashboard widgets that display a single tab)
- fallbackImage (Asset, an image that will be used in a layout if no image is set on an entry)
- hideUnpermittedSections (bool, Whether to hide sections a user does not have view permission instead of displaying a message. May lead to ugly empty tabs.)
- layoutSizes (array, which size is used by default for a layout)
- layoutWidth (array, the grid column width for a layout size. Technically the `minmax` value for a `grid-template-columns` css directive.)
- linkTarget (string, defaults to '_blank' to open edit screens in a new tab (default).)
- loadSectionsAsync (bool, Whether to load section html via ajax request. Loads section content when it becomes visible.)
- pluginTitle (string, label for primary navigation, page title. Defaults to 'Content Overview')
- purifierConfig (string|array The html purifier config used to make output from object templates safe.)
- replaceDashboard (bool Whether to remove dashboard link and redirect to contentoverview on login.)
- showLoadingIndicator (bool, Whether to show a loading indicator/overlay while an ajax request is pending.)
- showPages (string, default nav, where to show multiple pages: nav|sidebar|no)
- transforms (array, image transforms for layouts)
- useImagerX (bool, create image transforms with Imager-X plugin, if available. Defaults to true)
- widgetText (string, text for dashboard link widget)

Defaults are defined in `models\Settings.php`.

```php
<?php

return [
    'replaceDashboard' => true,
    'enableWidgets' => false,
];
```
