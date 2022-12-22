# Integrations

## Register action

Plugins or custom modules can register a [custom action class](../dev/action)

```php
use wsydney76\contentoverview\events\RegisterActionsEvent;
use wsydney76\contentoverview\services\ContentOverviewService;
use wsydney76\package\models\ReleaseAction; // your action here
...
Event::on(
    ContentOverviewService::class,
    ContentOverviewService::EVENT_REGISTER_ACTIONS,
    function(RegisterActionsEvent $event) {
        $event->actions['release'] = ReleaseAction::class; // your action here
    }
);
```

## Built-in integrations with wsydney76 plugins

Some integrations of other plugins are currently baked in as 'actions':

### Compare

Action: `compare`

Shows a comparison between a draft and the current version.

![Screenshot](/images/compare.jpg)

Requires `work` plugin. This is currently private, but an old PoC version (ported to Craft 4)
is available [here](https://github.com/wsydney76/work).

### Relationships

Action: `relationships`

Show incoming and outgoing relations in a popup:

![Screenshot](/images/relationships.jpg)

Requires `elementmap` plugin. This is currently private, but an old PoC version (ported to Craft 4)
is available [here](https://github.com/wsydney76/craft-elementmap).

### Release

Releases (publishes, enables) a draft or disabled entry. 

Since 5.3. Requires `package` plugin. PoC version is available [here](https://github.com/wsydney76/craft-package)