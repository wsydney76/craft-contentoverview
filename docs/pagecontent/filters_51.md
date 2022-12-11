# Filters

::: warning
Using filters has changed in V 5.2. The methods described here are deprecated, but should still work.
:::

## By Field

Entries can be filtered by a custom field value.

```php
->filters([
    $co->createFilter('field', 'topics'),

    $co->createFilter('field', 'assignedTo')       
        ->label('Responsible')
        ->orderBy('lastName, firstName'),
    
    $co->createFilter('field', 'workflowStatus'),
])
```

Currently supported:

* Entries fields
* Users fields
* Option fields (Dropdown)

![Screenshot](/images/search3.jpg)


## Status filter

Filter by workflow/entry status.

```php
$co->createFilter('status')->label('Workflow')
```

![Screenshot](/images/statusfilter.jpg)

Options are defined in the `statusFilterOptions` plugin setting.

## Custom filters

Additionally custom filters can be defined:

```php
->filters([
    $co->createFilter('custom', 'criticalreviews') // pseudo field handle to identify this filter in event handlers
        ->label('Critical Reviews')
        ->options([
            ['label' => 'Overdue', 'value' => 'overdue'],
            ['label' => 'Next week', 'value' => 'nextweek'],
        ])
    ])
])
```

![Screenshot](/images/customfilter.jpg)

Options can be set dynamically via an event:

```php
use wsydney76\contentoverview\events\DefineCustomFilterOptionsEvent;
use wsydney76\contentoverview\models\Filter;
Event::on(
    Filter::class,
    Filter::EVENT_DEFINE_CUSTOM_FILTER_OPTIONS,
    function(DefineCustomFilterOptionsEvent $event) {
        if ($event->filter->handle === 'criticalreviews') {
            $event->filter->options->prepend([
                'label' => 'A new option',
                'value' => 'aNewOption'
            ]) ;
        }
    }
);
```

A custom module then can apply filter params to the section query in an event handler, e.g.

```php

use wsydney76\contentoverview\events\FilterContentOverviewQueryEvent;
use wsydney76\contentoverview\models\Section;

...

Event::on(
    Section::class,
    Section::EVENT_FILTER_CONTENTOVERVIEW_QUERY,
    function(FilterContentOverviewQueryEvent $event) {
        if ($event->handle === 'criticalreviews') {
            switch ($event->value) {
                case 'overdue':
                {
                    $event->query
                        ->workflowStatus('inReview')
                        ->dueDate('< now');
                    break;
                }
                case 'nextweek':
                {
                   // 
                }
            }
        }
          
    }
    );
```

Multiple filters can take up a lot of space if used together with search, so you can push them
below or on top of the search:

```php
->filtersPosition('bottom') // top|bottom
```

Matrix subfields can also be used as filters:

```php
 $co->createFilter('field', 'streaming.streamingProvider')->orderBy('title')
 $co->createFilter('field', 'streaming.digitalMedium.streamingProvider')->orderBy('title')                        
```

Specify fields in the form `matrixFieldHandle.blockTypeHandle.subFieldHandle`.

If there is only one block type, you can use `matrixFieldHandle.subFieldHandle`

## Use 'selectize' for filters

Filters by default use a standard `select` input. For longer lists of options you may want to switch to a `selectize` input that allows searching.

```php
->useSelectize()
```

![Snapshot](/images/selectize.jpg)

Selectize inputs have a slightly different visual appearance than standard selects, so it is not a very good idea to mix them.