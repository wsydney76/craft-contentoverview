# Changelog

## Unreleased

* Allowed multisection setups. See Readme
* icon setup attribute is now be an object twig template.
* Any twig template can be overwritten with a custom template.
* Double-click on status opens slideout editor.

### Breaking change

* info and popupInfo section config settings now only allow a single string, in order to avoid confusion when using multi section config.  
  Either use html tags or, for more complex logic, use an `infoTemplate` setting.

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