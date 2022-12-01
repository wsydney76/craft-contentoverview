# Changelog

## Unreleased

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