# Changelog

## 5.4.2 2023-08-05

* Fixed an error in elementmap integration if there is only one site. 

## 5.4.0 2022-12-23

* Added the `ContentOverviewService::EVENT_GETSECTIONBYPATH` event.
* Added the `GetSectionByPathEvent` class.

## 5.3.0 2022-12-22

__Status: Beta__

* Added the `cpUrlTarget` action setting.
* Added the `ContentOverviewService::EVENT_REGISTER_ACTIONS` event.
* Added the `RegisterActionsEvent` class.

## 5.2.1 2022-12-20

* Fixed a bug where calling the `getHelp()` method from a derived section model would crash.
* Fixed a bug where the plugin initialization was not deferred, which could conflict with other plugins.

## 5.2.0 2022-12-19K

__Status: Beta__

Rework of filters.

* Added the `createFieldFilter`, `createStatusFilter`, `createCustomFilter`, `createElementSelectFilter` factory methods.
* Added support for `CustomFilter` classes.
* Added the `useElementSelect`, `selectLimit`, `multiSelectOperator`, `direction` filter settings.
* Deprecated the `createFilter($type)` method.

* Added the `Section::getInfoContent` method.
* Added scaffolding commands.
* Added the `ownProvisional` value to the `scope` section setting.

* Added the `ContentOverviewBaseModule` class as a base class for a custom module.

* Pages can now called with out beeing configured in the `pages` config file.
* Any query params are now passed to ajax requests as `extraParams`.

* Bumped minimum Craft version to 4.3.5

### Breaking change

* Improved consistency: The `infoTemplate` section settings now takes the `customTemplatePath` plugin setting into account.
* Renamed the `customTemplatePath` plugin setting to `customTemplateRoot`. Now contains a full (aliased) path to the templates root folder. 

## 5.1.2 2022-12-10

* Fixed a bug where page titles could repeat the same term twice.
* Docs updates (thanks to Klara).

## 5.1.1 2022-12-09

* Moved docs to GitHub pages.

## 5.1.0 2022-12-07

Make permission handling easier:

* Added a `Can view everything` permission.
* Added a `extraPermissions` plugin config setting.
* Added a `Permissions` chapter to README.

## 5.0.1 2022-12-06

* Fixed a bug where group/permisssion settings were not applied.

## 5.0.1 2022-12-06

* Fixed a bug where the elementmaps integration loaded a wrong asset bundle.

## 5.0.0 2022-12-05

Status: Ready for testing.

### Added

* Added the `ConfigHelper::require` method.
* Added the `useSelectize` section setting.
* Added the `permission` and `group` settings to all config objects.
* Added some missing phpDoc/comments/annotations.

### Changed

* __Breaking Change__: The configuration of sub-pages is moved from the `config/contentoverview.php` file to a dedictated `config/contentoverview/pages.php` file and uses fluent config.
* Config objects are hidden for users that do not match the `permission` and `group` settings.

### Upgrading from 4.x

If you did not use sub-pages, stop reading, nothing has changed.

* Create a file `config/contentoverview/pages.php` and set up your config as described in the 'Multi Page Setup' chapter in `README.md`. 
* Setting names and values have not changed.
* Exception: Omit a url setting, if used previously.
* Remove the `pages` config setting from `config/contentoverview.php`

## 4.1.0 2022-12-03

Status: Ready for testing.

### Added

* Added a `useImagerX` plugin setting. Defaults to true.
* Added a `custom` plugin setting that can hold any data you want to use somewhere in your config. Defaults to empty array.
* Added a `altTemplate` plugin setting that should be used to render a valid `alt` image attribute. Defaults to `{alt}`

### Changed

* Image transforms are now created via the Imager X plugin, if it is available and the `useImagerX` plugin setting is set to `true`.
* The `group` param in the page settings can now be an array. Users can see the page if they are in one of the groups.
* Some changes to Readme.

### Fixed

* The `DefineTableColumns` event missed the obligatory `user` attribute, has been added.
* Fixed a bug where the plugin crashed trying to find a section heading if both `heading` and `section` settings were missing. Displays 'Untitled section' now.
* Fixed a bug where 'New entry' and 'All entries' buttons were missing if both `query` and `section` config settings are set.

## 4.0.0 2022-12-02

* Multipage setup: Links can now appear in the main navigation (default) or in the sidebar.
* Added replaceDashboard setting.
* The `getPages` method now returns a collection of `Page` models and is moved to `ContenoverviewService`.
* Added `query` section setting.
* Added `imageRatio` section setting.
* Added `fallbackImageField` section config setting.
* * A new (temporary) plugin setting `useCSS` can be set to `all` to load the old CSS for legacy browsers, or `modern` to load a polyfill.
* Added a `fallbackImage` plugin setting (defaults to null) that will be used if no image is available for an entry.
* Added `titleObjectTemplate` section config setting (defaults to `{title}`)
* Added `table` layout
* Added `size` section config setting.
* Added `iconBgColor` section config setting.
* Added `DefineImageEvent`, `DefineIconEvent`
* Added `purifierConfig` plugin setting.
* Added `config` param to `ContentOverviewService::createSection`. This allows to create default settings and apply them to multiple sections.
* Added `layoutSizes` and `layoutWidths` plugin config setting.
* Improved CSS for arranging cards/cardlets inside their container.
* Added `loadSectionsAsync`, `showLoadingIndicator` plugin settings.
* The `custom` setting is now available for all models.
* Section html can now be refreshed.
* Added a `showRefreshButton` section config setting.
* Added the `enableCreateInSlideoutEditor` plugin config setting.
* Added help functionality.
* Added `slideoutTemplate` and `popupTemplate` actions.

### Removed

The `popup` section setting has been removed in favor of a `popup` action.

### Enhanced customization

New possibilities to make adjustments to a project have been introduced.

This is to prevent minor, very specific requirements from leading to a change request for the plugin.

* It is now possible to overwrite the Page/Tab/Column/Section/Action classes.
* Actions are now created as an Action model, that has an `isActiveForEntry` method taken into accout by the `getActions` method.
* Filters are now created as a Filter model.
* Added `DefinePagesEvent`, `DefineTabsEvent`, `DefineColumnsEvent`, `DefineSectionsEvent`, `DefineActionsEvent`.
* Added `DefineUserSetting` event and `Settings::getUserSetting()` method, be able to overwrite any setting on a user basis.

## 3.0.0 2022-11-18

Use this plugin in a real-life project, and don't be surprised to see a lot of
new ideas...

* Allowed multisection setups. See Readme
* icon setup attribute can now be an object twig template.
* Any twig template can be overwritten with a custom template.
* Enabled slideout editor.
* Added a `enableSlideoutEditor` plugin setting to disable that (its experimental and may not work in all cases...).
* Custom filters can be defined.
* Custom sort orders can be defined.
* Custom templates can be rendered in CP page blocks (sidebar, details etc.)
* Custom templates can be rendered instead of default sections.
* Dashboard widgets can be rendered instead of default sections.
* Custom actions can be added to an entry.
* Added 'showNewButton', 'showIndexButton' section config settings.
* Added 'elementType' section config setting.


### Breaking changes

A lot.

## 2.2.0 2022-11-11

* Added filtering by entries fields, users fields, options fields, including matrix sub fields (experimental).
* Added predefined search attributes, like `title:`
* Added `infoTemplate` section setting

Status : Ready for testing.

## 2.1.0 2022-11-10

* Added pagination to sections.
* Added search to sections.
* Section heading can now link to other page.

## 2.0.2 2022-11-09

Added layout documentation to README.

## 2.0.1 2022-11-09

Disabled settings page for now. Because it handled only a subset of settings,
possible conflicts could occur if making changes in different places in a weird order.

## 2.0.0 2022-11-08

Initial release.

Status: Feature complete for now, ready for testing.

In fact more a release candidate than a final version...