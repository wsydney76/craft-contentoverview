# Craft general config

Settings in `config/general.php` that are relevant for this plugin:

## defaultSearchTermOptions 

Search queries are executed respecting this setting. 

## postCpLoginRedirect 

You can redirect users after login. Be sure that this is a page that is available for all users.


```php
->postCpLoginRedirect('contentoverview')

->postCpLoginRedirect('contentoverview/page1#news')
```