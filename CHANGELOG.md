# Changelog

## Unreleased

* Multi page setup: Links can now appear in the main navigation (default) or in the sidebar.

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