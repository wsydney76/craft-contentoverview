# Performance

Response time is highly dependent on your individual config, so here are just a few notes:

* Obviously, more things on a page will make it slower, leading to more queries/image transforms (Sorry for this trivial
  statement...).
* So it is all about finding a balance.
* We found that people prefer a longer initial load time and having anything they need available from the start, rather
  than jumping around between different pages.
* Better hosting always pays off.
* By default, all content on a page is rendered server side (including all tabs).
* Set the [loadSectionsAsync](../config/common#loadsectionsasync) setting to `true` if the section html shall be loaded by ajax calls. The section
  will only be loaded if it is in the viewport.
* Set the [showLoadingIndicator](../config/plugin-config#showloadingindicator) plugin setting to `true` if you want a visual clue while an ajax request is running.
* Because single request will likely be fast, this can be somewhat confusing.
* Transformed images are generated on the fly if they don't already exist, so a lower [limit](../config/section-settings#limit) can speed up things.
* Images and their transforms are automatically eager loaded if defined via [imageField](../config/section-settings#imagefield) or [fallbackImageField](../config/section-settings#fallbackcimagefield).
* If you want to eager load other related elements, use the [Section::EVENT_MODIFY_CONTENTOVERVIEW_QUERY](../customize/events#modify-query) event or a [custom module](../dev/section#eager-loading).
* You can populate the [custom](../config/common#custom) setting in your config with any data in advance.
* You can overwrite any class if you need some special handling.