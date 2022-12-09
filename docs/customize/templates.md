# Overwrite templates

All twig templates are called like so:

```php
{% include [
    '_contentoverview/partials/entry.twig',
    'contentoverview/partials/entry.twig'
] %}
```

where the template root  `_contentoverview` by default points to your project's `templates/_contentoverview` folder.

This allows you to overwrite any twig template in case you have special needs.

Templates are included without an `only` parameter, making all variables available to them, because we know what our templates need, but maybe you need more in
your templates.

Required params passed to a template should be listed in an `@params` comment (no guarantee).

## Variables

Generally available variables:

* settings - The plugin settings
* page - The page object

Variables available within a section:

* sectionConfig - The section object containing all section settings
* sectionPath - A unique identifier of a section, enables ajax request to identify the section
* sectionPageNo - The current page shown in the section
* tab - the current tab object
* column - the current column object

Entry template and includes

* entry - You guessed it.