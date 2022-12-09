# Help

A help text can be displayed for the section.

You can use a simple string:

```php
->help('Help is on the way!')
```

or use a custom template:


```php
->help([
    'template' => 'help/needsattention.twig',  // or use 'text' => 'helptext
    'type' => 'warning' // optional, tip|warning
])
```

Custom templates live in the folder defined by the `customTemplatePath` plugin setting.

![Screenshot](/images/warning.jpg)

## Slideout

For more info about the section, you can configure a button that opens a custom template in a slideout.

```php
->help([
    'template' => 'help/needsattention.twig',
    'type' => 'warning',
    'buttonText' => 'Additional Info',
    'slideoutTemplate' => 'help/wtf-should-I-do-with-it.twig'
])
```

A `sectionConfig` variable is available.
