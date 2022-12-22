# Actions

Custom actions can be defined in the section config.

Actions can be:

* slideout: predefined, opens the entry in a slideout editor.
* delete: predefined, deletes the entry (with user confirmation).
* view: predefined, open the entry url in a new tab (experimental for non-live entries).
* compare: integration, shows a comparison draft <-> current in a slideout. *)
* relationships : integration, shows the relationships for an entry in a popup. **)
* release: integration, apply draft ***)
* A custom javascript function.
* A CP link to a page provided e.g. by a custom module.
* A custom controller action (executed with user confirmation).
* A template opened in a slideout or popup.

*) Requires `work` plugin. This is currently private, but an old PoC version (ported to Craft 4)
is available [here](https://github.com/wsydney76/work).

**) Requires `elementmap` plugin. This is currently private, but an old PoC version (ported to Craft 4)
is available [here](https://github.com/wsydney76/craft-elementmap).

*** Since 5.3. Requires `package` plugin. PoC version is available [here](https://github.com/wsydney76/craft-package)


```php
->actions([
    'slideout', // Predefined actions
    'delete',
    'view',
    $co->createAction(...),
    $co->createAction(...),
])
```

## Link to CP page

`elementId` and `draftId` parameters will be added to the url.

```php
$co->createAction()
    ->label('See version history')
    ->icon('@templates/_icons/history.svg')
    ->cpUrl('main/content/publish-release')
```

By default, links are opened in a new tab. Set `cpUrlTarget` to an empty string to open them in the current tab.

```php
->cpUrlTarget('') 
```

## Call a JavaScript function

Call a custom JavaScript function.

```php
$co->createAction()
    ->label('See version history')
    ->icon('@templates/_icons/history.svg')
    ->jsFunction('myApp_publish_release')
```

Signature:

```js
function myApp_publish_release(label, elementId, draftId, title, sectionPath, sectionPageNo)
```

Use sectionPath, sectionPageNo if you want to refresh the section html via `co_getSectionHtml`.

## Call a Controller action

`elementId` and `draftId` params will be posted to the action.
    
Requires that the controller action returns `->asSuccess(message)` or `->asFailure(message)`
    
Takes care of displaying cp notice/error, redirect/refreshing the section html.

```php
 $co->createAction()
    ->label('Publish all entries that belong to this package')
    ->icon('@templates/_icons/publish.svg')
    ->cpAction('main/content/publish-release')
    ->handle('publishAction')
```

### Controller example

```php
// modules/main/controllers/ContentController.php

<?php

namespace modules\main\controllers;

use Craft;
use craft\helpers\UrlHelper;use craft\web\Controller;

class ContentController extends Controller
{
    public function actionPublishRelease()
    {
    
        $this->requirePermission('yourpermission');

        $elementId = Craft::$app->request->getRequiredBodyParam('elementId');
        $draftId = Craft::$app->request->getBodyParam('draftId');

        if ($draftId) {
            return $this->asFailure("We cannot do anything with a draft.");
        }

        // The magic happens here.

        return $this->asSuccess("We did something with id: $elementId");
        
        // May also contain a redirect and notification details
        return $this->asSuccess(
            "We did something with id: $elementId",
            [],
            UrlHelper::cpUrl('work/summarize', {id: $elementId}),
            ['details' => 'Additional information']
        );
    }
}
```

## Slideout template

Open a custom template in a slideout.

Recommended for longer content.

Variables `sectionConfig`, `entry` will be available in the template

Shows 'info' icon by default

```php
$co->createAction()
    ->label('Details')        
    ->slideoutTemplate('help/moreinfos.twig')
```

## Popup template

Open a custom template in a popup.

Recommended for shorter content.

Variables `sectionConfig`, `entry` will be available in the template

Shows 'info' icon by default

```php
$co->createAction()
    ->label('Details')        
    ->popupTemplate('help/moreinfos.twig')
```

## isActiveForEntry method

The `Action` class implements a `isActiveForEntry(Entry $entry)` method, which by
default always return true.

You can create a custom class that overwrites this method and handles user roles/entry data.

```php
$co->createAction(PublishAction::class)

// PublishAction.php

<?php

namespace modules\contentoverview\models;

use craft\elements\Entry;
use wsydney76\contentoverview\models\Action;

class PublishAction extends Action
{
    public function isActiveForEntry(Entry $entry): bool
    {
        return // some complex logic here;
    }
}

```