# Common settings

The following settings can be applied to every object (page/tab/column/section/filter/action...)

## handle 

* Type: `string` 

A handle that helps to identify the object in events/custom templates.

```php
->handle('pendingReviews')
```

## custom  

* Type: `array` 

Can contain any data that you want to use in events/custom templates.

```php
->custom([
    'key' => 'value'
])
```

## permission 

* Type: `string` 

Only admins and users with this permission will see this object.

```php
->permission('yourCustomPermission')
```


## group 

* Type: `string|array`

Only admins and members of this group/one of these groups will see this object. Will be ignored if the more specific `permission` is set

```php
->group('festivalEditors')
```
