# Twig Page Blocks

[Control panel templates](https://craftcms.com/docs/4.x/extend/cp-templates.html#available-blocks) make
a number of twig `{% block %}` areas available, where custom templates can be rendered.

This can be helpful if you want to add instructions/help/guides/link lists/whatever to your page
in order to support editors.

Your template must live in the `settings.customTemplatePath` folder, by default `templates/_contentoverview`

```php
'pages' => [
    'page1' => ['label' => 'Site/News', 'url' => 'contentoverview/page1', 'blocks' => [
        'details' => 'blocks/co_page1_guide.twig',      
    ]],
]
```

## Available blocks

* sidebar
* details - wrap content in `<div class="meta" style="padding: 12px;">  </div>`
* toolbar
* footer

The `page` and `settings` variable are available in these templates.

## Example

```twig
<div class="meta" style="padding: 12px;">
    <h2>Guide for {{ page.label }}</h2>
    <p>
        Nullam vel sem. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Vivamus quis mi. Nunc nonummy metus. Vivamus euismod mauris.
    </p>
    <p>
        Aenean posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin urna dolor sagittis lacus. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Vestibulum eu odio. Fusce risus nisl, viverra et, tempor et, pretium in, sapien.
    </p>

    {% set entries = craft.entries
        .section('editorNews')
        .site(craft.app.request.queryParam('site'))
        .limit(5).all %}
    {% for entry in entries %}
    	<h3>{{ entry.title }}</h3>
        <p>
            {{ entry.body|md|purify }}
        </p>
    {% endfor %}
</div>
```