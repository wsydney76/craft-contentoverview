# Permissions

Admins are not restricted.

Non-admin users need the `Access Content Overview Plugin` permission.

There is a special `Can view everything (all pages, tabs, columns, sections)` permission, that you can assign to groups/users you do not want to be restricted.
Section specific permissions (viewentries, saveentries..) are still respected.

You can add custom permissions in your `config/contentoverview.php` file:

```php
'extraPermissions' => [
      'festivalAdmin' => [
          'label' => 'Festival Admin'
      ]
    ],
```

```php
// object config
->permission('festivalAdmin')
```

![Screenshot](/images/permissions.jpg)
