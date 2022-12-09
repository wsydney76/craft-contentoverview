# Custom Sections

You can create a custom section, where a custom template will be rendered.

```php
$co->createCustomSection()
    ->heading('Create Screening')
    ->customTemplate('custom/create_screening.twig')
    // Any custom settings, will be available in the template as 'sectionConfig.settings'
    ->settings([
        'key' => 'value',
        ... more settings
    ])
```

Your template must live in the `settings.customTemplatePath` folder, by default `templates/_contentoverview`.

Nothing special on the part of the plugin, but it opens amazing possibilities
to provide custom solutions for editors, whose work can thus be considerably facilitated.

See example.