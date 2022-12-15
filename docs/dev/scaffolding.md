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

Additionally, depending on the type of class, some you will be prompted for some settings. Press the ENTER key to continue with the default settings.

```shell{1,6-12,14}
php craft contentoverview/create/section MySection
Enter section settings.                                                                             
See docs for details: https://wsydney76.github.io/craft-contentoverview/config/section-settings.html
Press ENTER to use the default value.                                                          
Please note that your input is not validated.                                                       
Section handle:  news                                                                               
Heading:  
Limit:  12
Order By (e.g. title):  title
Image Field (fieldHandle):  featuredImage
Layout [list,cards,cardlets,line]:  cards
Size [tiny,small,medium,large]:  small
...
Enable Search [true,false]: true
File /var/www/html/modules/contentoverview/models/MySection.php created.
Refer to docs on how to activate your new class.
https://wsydney76.github.io/craft-contentoverview/dev/section.html
$co->createSection(MySection::class)

```

::: warning
Any inputs are not validated. So be sure to enter valid input.
:::


::: tip
Use `ddev craft ...` if you are using DDEV.
:::
