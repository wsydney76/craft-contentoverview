# Filters

::: info
Using filters has changed in V 5.2. The [old methods](./filters_51) are deprecated, but should still work.
:::

## Field Filters

Entries can be filtered by a custom field value.

```php
->filters([
    $co->createFieldFilter('topics'),

    $co->createFieldFilter('assignedTo')       
        ->label('Responsible')
        ->orderBy('lastName, firstName'),
    
    $co->createFieldFilter('workflowStatus')
     
])
```

Currently supported:

* Entries fields
* Users fields
* Option fields (Dropdown)

![Screenshot](/images/search3.jpg)

Matrix subfields can also be used as filters:

```php
 $co->createFieldFilter('streaming.streamingProvider')->orderBy('title')
 $co->createFieldFilter('streaming.digitalMedium.streamingProvider')->orderBy('title')                        
```

Specify fields in the form `matrixFieldHandle.blockTypeHandle.subFieldHandle`.

If there is only one block type, you can use `matrixFieldHandle.subFieldHandle`

You can use the `useSelectize` or `useElementSelect` settings (see below) for a better user experience.

## Status filter

Filter by workflow/entry status.

```php
$co->createStatusFilter()->label('Workflow')
```

![Screenshot](/images/statusfilter.jpg)

Options are defined in the `statusFilterOptions` plugin setting.

## Custom filters

Additional custom filters can be defined via a custom filter class:

```php
 $co->createCustomFilter(CriticalReviewsFilter::class)
    ->label('Critical Reviews')
    ->handle('criticalreviews')
    ->options([
        ['label' => 'Overdue', 'value' => 'overdue'],
        ['label' => 'Next week', 'value' => 'nextweek'],
    ])
```

![Screenshot](/images/customfilter.jpg)

### Filter class example.

```php
<?php

namespace modules\contentoverview\filters;

use craft\elements\db\ElementQueryInterface;
use wsydney76\contentoverview\models\filters\CustomFilter;
use wsydney76\contentoverview\models\Section;

class CriticalReviewsFilter extends CustomFilter
{
    public function modifyQuery(Section $sectionConfig, array $filter, ElementQueryInterface $query)
    {
        switch ($filter['value']) {
            case 'overdue':
            {
                $query
                    ->workflowStatus('inReview')
                    ->dueDate('< now');
                break;
            }
            case 'nextweek':
            {
                // ...               
            }
        }
    }

}
```

Specify the `modifyQuery` function and update the `$query` parameter.

The `$filter` parameter will contain `handle` and `value`:

```php
[
    'handle' => 'criticalreviews'
    'value' => 'overdue'
]
```

If additional parameters are fix, you can hardcode them in your class:

```php
$co->createCustomFilter(CriticalReviewsFilter::class);
```

```php
public string $handle = 'criticalreviews';
public string $label = 'Critical Reviews';
public array|Collection $options = [
    ['label' => 'Overdue', 'value' => 'overdue'],
    ['label' => 'Next week', 'value' => 'nextweek'],
];
```

Options and the executed query can also be handled via [events](../customize/events#support-custom-filters).

## Filter settings

### handle

* Type: `string`

A unique handle. The field handle for field filters is set by `createFieldFilter($handle)`

```php
->handle('criticalreviews')
```

### label

* Type: `string`

The label used for the select box. Defaults to field name for field filters.

```php
->label('Critical Reviews')
```

### options

The options used for the select box. Only relevant for custom filters.

* Type: `array|Collection`

```php
->options([
        ['label' => 'Overdue', 'value' => 'overdue'],
        ['label' => 'Next week', 'value' => 'nextweek'],
    ])
```

### useSelectize

* Type: `bool`
* Default: `false`

Filters by default use a standard `select` input. For longer lists of options you may want to switch to a `selectize` input that allows searching.


```php
->useSelectize()
```

![Snapshot](/images/selectize.jpg)

Selectize inputs have a slightly different visual appearance than standard selects, so it is not a very good idea to mix them.

### useElementSelect

* Type: `bool`
* Default: `false`

Entries/users field filters only.

Use Crafts element select modal to select elements.

::: warning
Experimental. Uses a lot of undocumented stuff, will not trigger all events or filter class methods.
:::

### selectLimit

* Type: `int`
* Default: `1`

Limit of elements that can be selected in an element select. If multiple elements are selected, this will result in an `OR` condition.

### Example for using element selects

```php
$co->createFieldFilter('assignedTo')
    ->useElementSelect()
    ->selectLimit(10),
$co->createFieldFilter('topics')
    ->useElementSelect()
    ->selectLimit(10),
```

![Snapshot](/images/elementselect.jpg)

### userGroups

* Type: `string|array`

Users field filters only, if `useElementSelect` is not set. The user group(s) from which the user options will be selected.

```php
->userGroups(['contentEditors', 'festivalAdmin'])
```

::: info
This is a workaround, because the configured sources of the user field are currently not respected.
::: 


## Filter position

Multiple filters can take up a lot of space if used together with search, so you can push them
below or on top of the search in your section config:

```php
// Section config
->filtersPosition('bottom') // top|bottom
```