# Common settings

The following settings can be applied to every object (page/tab/column/section/filter/action...)

## handle 

* Type: `string` 

A handle that helps to identify the object in events/custom templates.

## custom  

* Type: `array` 

Can contain any data that you want to use in events/custom templates.

## permission 

* Type: `string` 

Only admins and users with this permission will see this object.

## group 

* Type: `string|array`

Only admins and members of this group/one of these groups will see this object. Will be ignored if the more specific `permission` is set

