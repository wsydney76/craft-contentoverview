import{_ as e,c as l,o as i,a as t}from"./app.ccba37ea.js";const g=JSON.parse('{"title":"Section settings","description":"","frontmatter":{},"headers":[{"level":2,"title":"actions","slug":"actions","link":"#actions","children":[]},{"level":2,"title":"allSites","slug":"allsites","link":"#allsites","children":[]},{"level":2,"title":"entryType","slug":"entrytype","link":"#entrytype","children":[]},{"level":2,"title":"fallbackImageField","slug":"fallbackimagefield","link":"#fallbackimagefield","children":[]},{"level":2,"title":"filters","slug":"filters","link":"#filters","children":[]},{"level":2,"title":"filtersPosition","slug":"filtersposition","link":"#filtersposition","children":[]},{"level":2,"title":"heading","slug":"heading","link":"#heading","children":[]},{"level":2,"title":"help","slug":"help","link":"#help","children":[]},{"level":2,"title":"icon","slug":"icon","link":"#icon","children":[]},{"level":2,"title":"iconBgColor","slug":"iconbgcolor","link":"#iconbgcolor","children":[]},{"level":2,"title":"imageField","slug":"imagefield","link":"#imagefield","children":[]},{"level":2,"title":"imageRatio","slug":"imageratio","link":"#imageratio","children":[]},{"level":2,"title":"info","slug":"info","link":"#info","children":[]},{"level":2,"title":"infoTemplate","slug":"infotemplate","link":"#infotemplate","children":[]},{"level":2,"title":"layout","slug":"layout","link":"#layout","children":[]},{"level":2,"title":"limit","slug":"limit","link":"#limit","children":[]},{"level":2,"title":"linkToPage","slug":"linktopage","link":"#linktopage","children":[]},{"level":2,"title":"orderBy","slug":"orderby","link":"#orderby","children":[]},{"level":2,"title":"ownDraftsOnly","slug":"owndraftsonly","link":"#owndraftsonly","children":[]},{"level":2,"title":"query","slug":"query","link":"#query","children":[]},{"level":2,"title":"scope","slug":"scope","link":"#scope","children":[]},{"level":2,"title":"search","slug":"search","link":"#search","children":[]},{"level":2,"title":"section","slug":"section","link":"#section","children":[]},{"level":2,"title":"showIndexButton","slug":"showindexbutton","link":"#showindexbutton","children":[]},{"level":2,"title":"showNewButton","slug":"shownewbutton","link":"#shownewbutton","children":[]},{"level":2,"title":"showRefreshButton","slug":"showrefreshbutton","link":"#showrefreshbutton","children":[]},{"level":2,"title":"size","slug":"size","link":"#size","children":[]},{"level":2,"title":"sortByScore","slug":"sortbyscore","link":"#sortbyscore","children":[]},{"level":2,"title":"status","slug":"status","link":"#status","children":[]},{"level":2,"title":"titleObjectTemplate","slug":"titleobjecttemplate","link":"#titleobjecttemplate","children":[]}],"relativePath":"config/section-settings.md"}'),a={name:"config/section-settings.md"},o=t(`<h1 id="section-settings" tabindex="-1">Section settings <a class="header-anchor" href="#section-settings" aria-hidden="true">#</a></h1><p>Settings for sections, in alphabetical order:</p><div class="language-php"><button title="Copy Code" class="copy"></button><span class="lang">php</span><pre class="shiki"><code><span class="line"><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">co</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">createSection</span><span style="color:#89DDFF;">(</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">layout</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">cards</span><span style="color:#89DDFF;">&#39;</span></span>
<span class="line"></span></code></pre></div><p>If no default value is mentioned, the setting will default to <code>empty</code> (empty string, empty array, null, depending on the type).</p><h2 id="actions" tabindex="-1">actions <a class="header-anchor" href="#actions" aria-hidden="true">#</a></h2><ul><li>Type: <code>array</code></li></ul><p>The actions available to the section. See <a href="./../pagecontent/actions.html">Actions</a>.</p><h2 id="allsites" tabindex="-1">allSites <a class="header-anchor" href="#allsites" aria-hidden="true">#</a></h2><ul><li>Type: <code>bool</code></li><li>Default: <code>false</code></li></ul><p>true = display unique entries from all sites.</p><h2 id="entrytype" tabindex="-1">entryType <a class="header-anchor" href="#entrytype" aria-hidden="true">#</a></h2><ul><li>Type: <code>array|string</code></li></ul><p>EntryType handle</p><h2 id="fallbackimagefield" tabindex="-1">fallbackImageField <a class="header-anchor" href="#fallbackimagefield" aria-hidden="true">#</a></h2><ul><li>Type: <code>array|string</code></li></ul><p>Name of an image field to use if there is no image set in <code>imageField</code>.</p><h2 id="filters" tabindex="-1">filters <a class="header-anchor" href="#filters" aria-hidden="true">#</a></h2><ul><li>Type: <code>array</code></li></ul><p>Array of filter definitions. See <a href="./../pagecontent/filters.html">Filters</a>.</p><h2 id="filtersposition" tabindex="-1">filtersPosition <a class="header-anchor" href="#filtersposition" aria-hidden="true">#</a></h2><ul><li>Type: <code>string</code></li><li>Default: <code>inline</code></li></ul><p>Positions of filter inputs.</p><ul><li><code>inline</code> beneath search inputs</li><li><code>top</code> above search inputs</li><li><code>bottom</code> below search inputs</li></ul><h2 id="heading" tabindex="-1">heading <a class="header-anchor" href="#heading" aria-hidden="true">#</a></h2><ul><li>Type: <code>string</code></li></ul><p>Heading of the section. The <code>Section::getHeading()</code> method will return Crafts section names, if this setting is empty.</p><h2 id="help" tabindex="-1">help <a class="header-anchor" href="#help" aria-hidden="true">#</a></h2><ul><li>Type: <code>array|string</code></li></ul><p>Help text for the section. See <a href="./../pagecontent/help.html">Help</a>.</p><h2 id="icon" tabindex="-1">icon <a class="header-anchor" href="#icon" aria-hidden="true">#</a></h2><ul><li>Type: <code>array|string</code></li></ul><p>Path to a svg icon that will be displayed if no image is found.</p><p>See <a href="./page-config.html#multi-section-setup">Multi Section Setup</a>.</p><h2 id="iconbgcolor" tabindex="-1">iconBgColor <a class="header-anchor" href="#iconbgcolor" aria-hidden="true">#</a></h2><ul><li>Type: <code>string</code></li><li>Default: <code>var(--gray-200)</code></li></ul><p>The background color for an icon.</p><h2 id="imagefield" tabindex="-1">imageField <a class="header-anchor" href="#imagefield" aria-hidden="true">#</a></h2><ul><li>Type: <code>array|string</code></li></ul><p>Name of the image field to use.</p><p>See <a href="./page-config.html#multi-section-setup">Multi Section Setup</a>.</p><h2 id="imageratio" tabindex="-1">imageRatio <a class="header-anchor" href="#imageratio" aria-hidden="true">#</a></h2><ul><li>Type: <code>float</code></li></ul><p>Aspect ratio of the image. Only makes sense for card layout.</p><p>If empty, the <a href="./plugin-config.html#transforms">transforms</a> setting wil determine the aspect ratio.</p><h2 id="info" tabindex="-1">info <a class="header-anchor" href="#info" aria-hidden="true">#</a></h2><ul><li>Type: <code>string|array</code></li></ul><p>Object template to render in addition to the title.</p><p>See <a href="./page-config.html#multi-section-setup">Multi Section Setup</a>.</p><h2 id="infotemplate" tabindex="-1">infoTemplate <a class="header-anchor" href="#infotemplate" aria-hidden="true">#</a></h2><ul><li>Type: <code>string|array</code></li></ul><p>Path to a twig template inside the projects templates folder. Will be called with an entries variable.</p><p>See <a href="./page-config.html#multi-section-setup">Multi Section Setup</a>.</p><h2 id="layout" tabindex="-1">layout <a class="header-anchor" href="#layout" aria-hidden="true">#</a></h2><ul><li>Type: <code>string</code></li></ul><p>The layout used to display entries. (list|cardlets|cards|line|table)</p><p>The <code>Section::getLayout()</code> method will take the <a href="./plugin-config.html#defaultlayout">defaultLayout</a> plugin setting into account, if this setting is empty.</p><h2 id="limit" tabindex="-1">limit <a class="header-anchor" href="#limit" aria-hidden="true">#</a></h2><ul><li>Type: <code>int</code></li><li>Default: <code>9999</code></li></ul><p>Number of entries to show on one section page.</p><h2 id="linktopage" tabindex="-1">linkToPage <a class="header-anchor" href="#linktopage" aria-hidden="true">#</a></h2><ul><li>Type: <code>string</code></li></ul><p>The key of a page the heading is linked to. May contain an anchor, e.g. <code>page1#tab1</code>.</p><h2 id="orderby" tabindex="-1">orderBy <a class="header-anchor" href="#orderby" aria-hidden="true">#</a></h2><ul><li>Type: <code>string|array</code></li></ul><p>The sort order used by the sections query. If empty, the Crafts defaults will be used.</p><p>See <a href="https://craftcms.com/docs/4.x/entries.html#orderby" target="_blank" rel="noreferrer">docs</a></p><h2 id="owndraftsonly" tabindex="-1">ownDraftsOnly <a class="header-anchor" href="#owndraftsonly" aria-hidden="true">#</a></h2><ul><li>Type: <code>bool</code></li><li>Default: <code>false</code></li></ul><p>If true and scope is defined: show only drafts created by the current user.</p><h2 id="query" tabindex="-1">query <a class="header-anchor" href="#query" aria-hidden="true">#</a></h2><ul><li>Type: <code>ElementQuery</code></li></ul><p>Define your own query.</p><h2 id="scope" tabindex="-1">scope <a class="header-anchor" href="#scope" aria-hidden="true">#</a></h2><ul><li>Type: <code>string</code></li></ul><p>Whether drafts should be shown.</p><ul><li>drafts: Show &#39;regular&#39; drafts</li><li>provisional: Show &#39;provisional&#39; drafts</li><li>all: Show all drafts and all &#39;published&#39; entries</li></ul><p>If empty, only &#39;published&#39; entries will be included.</p><h2 id="search" tabindex="-1">search <a class="header-anchor" href="#search" aria-hidden="true">#</a></h2><ul><li>Type: <code>bool</code></li><li>Default: <code>false</code></li></ul><p>Whether search will be enabled.</p><h2 id="section" tabindex="-1">section <a class="header-anchor" href="#section" aria-hidden="true">#</a></h2><ul><li>Type: <code>array|string</code></li></ul><p>Craft section handle(s).</p><p>Will be passed to the section query, however if a <code>query</code> setting is set, it will only be used for default headings/permission checks.</p><h2 id="showindexbutton" tabindex="-1">showIndexButton <a class="header-anchor" href="#showindexbutton" aria-hidden="true">#</a></h2><ul><li>Type: <code>bool</code></li><li>Default: <code>true</code></li></ul><p>Whether button &#39;All entries&#39; will be shown.</p><h2 id="shownewbutton" tabindex="-1">showNewButton <a class="header-anchor" href="#shownewbutton" aria-hidden="true">#</a></h2><ul><li>Type: <code>bool</code></li><li>Default: <code>true</code></li></ul><p>Whether button &#39;New entry&#39; will be shown.</p><h2 id="showrefreshbutton" tabindex="-1">showRefreshButton <a class="header-anchor" href="#showrefreshbutton" aria-hidden="true">#</a></h2><ul><li>Type: <code>bool</code></li><li>Default: <code>true</code></li></ul><p>Whether to show a refresh button for this section.</p><h2 id="size" tabindex="-1">size <a class="header-anchor" href="#size" aria-hidden="true">#</a></h2><p>string, the grid colum size of an entry for layouts card, cardlet. (tiny|small|medum|large|card)</p><h2 id="sortbyscore" tabindex="-1">sortByScore <a class="header-anchor" href="#sortbyscore" aria-hidden="true">#</a></h2><p>bool, whether search results will be sorted by score. default=false</p><h2 id="status" tabindex="-1">status <a class="header-anchor" href="#status" aria-hidden="true">#</a></h2><ul><li>Type: <code>string|array</code></li></ul><p>See <a href="https://craftcms.com/docs/4.x/entries.html#status" target="_blank" rel="noreferrer">docs</a></p><p>If empty, all entries with all status (live, disabled, pending, expired) will be found.</p><h2 id="titleobjecttemplate" tabindex="-1">titleObjectTemplate <a class="header-anchor" href="#titleobjecttemplate" aria-hidden="true">#</a></h2><ul><li>Type: <code>string</code></li><li>Default: <code>{title}</code></li></ul><p>string, an object template that will be rendered for the title in a layout.</p>`,104),n=[o];function r(s,d,c,h,p,u){return i(),l("div",null,n)}const y=e(a,[["render",r]]);export{g as __pageData,y as default};
