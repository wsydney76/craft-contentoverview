# Events

## Modify Query

Custom modules can extend the configuration by adding keys to the `custom` section config array and modify the query via an
event:

```php
use wsydney76\contentoverview\events\ModifyContentOverviewQueryEvent;
use wsydney76\contentoverview\models\Section;


Event::on(
    Section::class,
    Section::EVENT_MODIFY_CONTENTOVERVIEW_QUERY,
    function(ModifyContentOverviewQueryEvent $event) {
        /** @var Section $sectionConfig */
        $sectionConfig = $event->sender;
        if (isset($sectionConfig->custom['tagline'])) {
            $event->query->tagline($sectionConfig->custom['tagline']);
        }
        
        // Add eager loading related elements that appear in info 
        $event->query->with(['assignedTo ...'])
    }
);
```

## Support Custom Filters

The `Section::EVENT_FILTER_CONTENTOVERVIEW_QUERY` and `Section::EVENT_DEFINE_CUSTOM_FILTER_OPTIONS` events
are described in the [Filters](../pagecontent/filters) chapter.

## Modify Collections

Every collection of models in the chain Pages -> Tabs -> Columns -> Sections -> Actions/Filters/TableColumns can be
modified.

This is especially useful if you want to apply rules based on a users role and entry content.

| Event                                      | Event Class             | Property              |
|--------------------------------------------|-------------------------|-----------------------|
| ContentOverviewService::EVENT_DEFINE_PAGES | DefinePagesEvent        | $pages                |
| Page::EVENT_DEFINE_TABS                    | DefineTabsEvent         | $tab                  |
| Tab::EVENT_DEFINE_COLUMNS                  | DefineColumnsEvent      | $columns              |
| Column::EVENT_DEFINE_SECTIONS              | DefineSectionsEvent     | $sections             |
| Section::EVENT_DEFINE_ACTIONS              | DefineActionsEvent      | $entry, $actions      |
| Section::EVENT_DEFINE_FILTERS              | DefineFiltersEvent      | $filters              |
| TableSection::EVENT_DEFINE_TABLECOLUMNS    | DefineTableColumnsEvent | $table, $tableColumns |

Add a `handle` to a model so that it can easily be identified in your event handler.

Additionally, you can add a `custom` setting to any model that contains arbitrary data.

All event properties are `Collections`, so they can be modified
using [all collection methods](https://laravel.com/docs/9.x/collections#available-methods).

For convenience, all event classes have a `user` property containing the current user, and, where appropriate, a
reference to their parent object.

For a better overview it is recommended to define all possible objects in your config files and filter out what is not
needed, instead of adding stuff in your event handlers.

Examples:

```php
Event::on(
    ContentOverviewService::class,
    ContentOverviewService::EVENT_DEFINE_PAGES,
    function(DefinePagesEvent $event) {
        if (!$event->user->can('yourpermission')) {
            $event->pages = $event->pages->filter(function($page) {
                return $page->handle !== 'workpage';
            });
        }
    }
);
```

```php
Event::on(
    Section::class,
    Section::EVENT_DEFINE_ACTIONS,
    function(DefineActionsEvent $event) {
        $event->actions = $event->actions->filter(function($action) use ($event) {
            if ($action instanceof Action && $action->handle === 'publishAction') {
                return $event->entry->status !== 'live';
            }
            return true;
        });
    }
);
```

## Modify Settings for Current User

Sometimes it makes sense to modify plugin settings for the current user, based on their role or preferences.

Currently implemented for the `replaceDashboard`, `showPages`, `enableCreateInSlideoutEditor` settings.

The event contains `$key` and `$value` properties.

```php
Event::on(
    Settings::class,
    Settings::EVENT_DEFINE_USER_SETTING,
    function(DefineUserSettingEvent $event) {
        $currentUser = Craft::$app->user;
        
        // Give users a custom field so that they can decide whether to see links in the main nav or in sidebar
        // depending on their screen size
        if ($event->key === 'showPages') {
            $showPages = $currentUser->identity->showContentoverviewPages->value ?? 'default';
            if ($showPages !== 'default') {
                $event->value = $showPages;
            }
        }

        // Always show dashboard for admins
        if ($event->key === 'replaceDashboard') {
            if ($currentUser->getIsAdmin()) {
                $event->value = false;
            }
        }
    }
);
```

## Define images/icons.

See [Images and Icons](../pagecontent/images) for how to use `Section::EVENT_DEFINE_IMAGE`, `Section::EVENT_DEFINE_ICON` events.