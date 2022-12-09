# Performance

Response time is highly dependent on your individual config, so here are just a few notes:

* Obviously, more things on a page will make it slower, leading to more queries/image transforms (Sorry for this trivial
  statement...).
* So it is all about finding a balance.
* We found that people prefer a longer initial load time and having anything they need available from the start, rather
  than jumping around between different pages.
* Better hosting always pays off.
* By default, all content on a page is rendered server side (including all tabs).
* Set the `loadSectionsAsync` plugin setting to `true` if the section html shall be loaded by ajax calls. So section
  will only be loaded if the section is in the viewport.
* Set the `showLoadingIndicator` plugin setting to `true` if you want a visual clue while an ajax request is running.
* Because single request will likely be fast, this can be somewhat confusing.
* Transformed images are generated on the fly if they don't already exist, so a lower `limit` can speed up things.
* Images and their transforms are automatically eager loaded if defined via `imageField` or `fallbackImageField`.
* If you want to eager load other related elements, use the `Section::EVENT_MODIFY_CONTENTOVERVIEW_QUERY` event.
* You can populate the `custom` setting in your config with any data in advance.
* You can overwrite any class if you need some special handling.