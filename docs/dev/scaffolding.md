# Scaffolding

There are a couple of CLI commands you can use to create a starting point for custom classes.

```
php craft contentoverview/create/<type> <className> 
```

Currently implemented:

```
php craft contentoverview/create/module
php craft contentoverview/create/section
php craft contentoverview/create/filter
php craft contentoverview/create/action
php craft contentoverview/create/service
```

You will be prompted for a class name if it is not provided as a parameter.

::: warning
The class name is not checked. So be sure to enter a valid class name.
:::

::: tip
Use `ddev craft ...` if you are using DDEV.
:::
