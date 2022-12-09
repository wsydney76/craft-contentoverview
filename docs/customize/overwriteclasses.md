# Overwrite Classes

Classes are instantiated via a poor man's version of dependency injection:
The class names are defined in `models\Settings.php`.

```php
    public string $serviceClass = ContentOverviewService::class;
    public string $pageClass = Page::class;
    public string $tabClass = Tab::class;
    public string $columnClass = Column::class;
    public string $sectionClass = Section::class;
    public string $actionClass = Action::class;
    public string $filterClass = Filter::class;
    public string $tableSectionClass = TableSection::class;
    public string $tableColumnClass = TableColumn::class;
```

So when you feel the indomitable need to use your own classes, you can do so
by overwriting the setting in `config\contentoverview.php` with the name of
a class that extends the plugin's class.

```php
public string $sectionClass = \modules\cp\models\MyClassThatDoesItBetter::class;
```