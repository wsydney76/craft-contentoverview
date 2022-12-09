import{_ as s,c as n,o as a,a as l}from"./app.e8f0dc17.js";const A=JSON.parse('{"title":"Events","description":"","frontmatter":{},"headers":[{"level":2,"title":"Modify Query","slug":"modify-query","link":"#modify-query","children":[]},{"level":2,"title":"Support Custom Filters","slug":"support-custom-filters","link":"#support-custom-filters","children":[]},{"level":2,"title":"Modify Collections","slug":"modify-collections","link":"#modify-collections","children":[]},{"level":2,"title":"Modify Settings for Current User","slug":"modify-settings-for-current-user","link":"#modify-settings-for-current-user","children":[]},{"level":2,"title":"Define images/icons.","slug":"define-images-icons","link":"#define-images-icons","children":[]}],"relativePath":"customize/events.md"}'),o={name:"customize/events.md"},p=l(`<h1 id="events" tabindex="-1">Events <a class="header-anchor" href="#events" aria-hidden="true">#</a></h1><h2 id="modify-query" tabindex="-1">Modify Query <a class="header-anchor" href="#modify-query" aria-hidden="true">#</a></h2><p>Custom modules can extend the configuration by adding keys to the <code>custom</code> section config array and modify the query via an event:</p><div class="language-php"><button title="Copy Code" class="copy"></button><span class="lang">php</span><pre class="shiki"><code><span class="line"><span style="color:#F78C6C;">use</span><span style="color:#FFCB6B;"> </span><span style="color:#A6ACCD;">wsydney76</span><span style="color:#89DDFF;">\\</span><span style="color:#A6ACCD;">contentoverview</span><span style="color:#89DDFF;">\\</span><span style="color:#A6ACCD;">events</span><span style="color:#89DDFF;">\\</span><span style="color:#A6ACCD;">ModifyContentOverviewQueryEvent</span><span style="color:#89DDFF;">;</span></span>
<span class="line"><span style="color:#F78C6C;">use</span><span style="color:#FFCB6B;"> </span><span style="color:#A6ACCD;">wsydney76</span><span style="color:#89DDFF;">\\</span><span style="color:#A6ACCD;">contentoverview</span><span style="color:#89DDFF;">\\</span><span style="color:#A6ACCD;">models</span><span style="color:#89DDFF;">\\</span><span style="color:#A6ACCD;">Section</span><span style="color:#89DDFF;">;</span></span>
<span class="line"></span>
<span class="line"></span>
<span class="line"><span style="color:#FFCB6B;">Event</span><span style="color:#89DDFF;">::</span><span style="color:#82AAFF;">on</span><span style="color:#89DDFF;">(</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#FFCB6B;">Section</span><span style="color:#89DDFF;">::</span><span style="color:#F78C6C;">class</span><span style="color:#89DDFF;">,</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#FFCB6B;">Section</span><span style="color:#89DDFF;">::</span><span style="color:#A6ACCD;">EVENT_MODIFY_CONTENTOVERVIEW_QUERY</span><span style="color:#89DDFF;">,</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#C792EA;">function</span><span style="color:#89DDFF;">(</span><span style="color:#FFCB6B;">ModifyContentOverviewQueryEvent</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">event</span><span style="color:#89DDFF;">)</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">{</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#676E95;">/** </span><span style="color:#F78C6C;">@var</span><span style="color:#676E95;"> </span><span style="color:#FFCB6B;">Section</span><span style="color:#676E95;"> $sectionConfig */</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">sectionConfig </span><span style="color:#89DDFF;">=</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">event</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">sender</span><span style="color:#89DDFF;">;</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">if</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">(</span><span style="color:#82AAFF;">isset</span><span style="color:#89DDFF;">($</span><span style="color:#A6ACCD;">sectionConfig</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">custom</span><span style="color:#89DDFF;">[</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">tagline</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">]))</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">{</span></span>
<span class="line"><span style="color:#A6ACCD;">            </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">event</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">query</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">tagline</span><span style="color:#89DDFF;">($</span><span style="color:#A6ACCD;">sectionConfig</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">custom</span><span style="color:#89DDFF;">[</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">tagline</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">]);</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">}</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span></span>
<span class="line"><span style="color:#89DDFF;">        </span><span style="color:#676E95;">// Add eager loading related elements that appear in info </span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">event</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">query</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">with</span><span style="color:#89DDFF;">([</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">assignedTo ...</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">])</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#89DDFF;">}</span></span>
<span class="line"><span style="color:#89DDFF;">);</span></span>
<span class="line"></span></code></pre></div><h2 id="support-custom-filters" tabindex="-1">Support Custom Filters <a class="header-anchor" href="#support-custom-filters" aria-hidden="true">#</a></h2><p>The <code>Section::EVENT_FILTER_CONTENTOVERVIEW_QUERY</code> and <code>Section::EVENT_DEFINE_CUSTOM_FILTER_OPTIONS</code> events are described in the <a href="./../pagecontent/filters.html">Filters</a> chapter.</p><h2 id="modify-collections" tabindex="-1">Modify Collections <a class="header-anchor" href="#modify-collections" aria-hidden="true">#</a></h2><p>Every collection of models in the chain Pages -&gt; Tabs -&gt; Columns -&gt; Sections -&gt; Actions/Filters/TableColumns can be modified.</p><p>This is especially useful if you want to apply rules based on a users role and entry content.</p><table><thead><tr><th>Event</th><th>Event Class</th><th>Property</th></tr></thead><tbody><tr><td>ContentOverviewService::EVENT_DEFINE_PAGES</td><td>DefinePagesEvent</td><td>$pages</td></tr><tr><td>Page::EVENT_DEFINE_TABS</td><td>DefineTabsEvent</td><td>$tab</td></tr><tr><td>Tab::EVENT_DEFINE_COLUMNS</td><td>DefineColumnsEvent</td><td>$columns</td></tr><tr><td>Column::EVENT_DEFINE_SECTIONS</td><td>DefineSectionsEvent</td><td>$sections</td></tr><tr><td>Section::EVENT_DEFINE_ACTIONS</td><td>DefineActionsEvent</td><td>$entry, $actions</td></tr><tr><td>Section::EVENT_DEFINE_FILTERS</td><td>DefineFiltersEvent</td><td>$filters</td></tr><tr><td>TableSection::EVENT_DEFINE_TABLECOLUMNS</td><td>DefineTableColumnsEvent</td><td>$table, $tableColumns</td></tr></tbody></table><p>Add a <code>handle</code> to a model so that it can easily be identified in your event handler.</p><p>Additionally, you can add a <code>custom</code> setting to any model that contains arbitrary data.</p><p>All event properties are <code>Collections</code>, so they can be modified using <a href="https://laravel.com/docs/9.x/collections#available-methods" target="_blank" rel="noreferrer">all collection methods</a>.</p><p>For convenience, all event classes have a <code>user</code> property containing the current user, and, where appropriate, a reference to their parent object.</p><p>For a better overview it is recommended to define all possible objects in your config files and filter out what is not needed, instead of adding stuff in your event handlers.</p><p>Examples:</p><div class="language-php"><button title="Copy Code" class="copy"></button><span class="lang">php</span><pre class="shiki"><code><span class="line"><span style="color:#FFCB6B;">Event</span><span style="color:#89DDFF;">::</span><span style="color:#82AAFF;">on</span><span style="color:#89DDFF;">(</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#FFCB6B;">ContentOverviewService</span><span style="color:#89DDFF;">::</span><span style="color:#F78C6C;">class</span><span style="color:#89DDFF;">,</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#FFCB6B;">ContentOverviewService</span><span style="color:#89DDFF;">::</span><span style="color:#A6ACCD;">EVENT_DEFINE_PAGES</span><span style="color:#89DDFF;">,</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#C792EA;">function</span><span style="color:#89DDFF;">(</span><span style="color:#FFCB6B;">DefinePagesEvent</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">event</span><span style="color:#89DDFF;">)</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">{</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">if</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">(!$</span><span style="color:#A6ACCD;">event</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">user</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">can</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">yourpermission</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">))</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">{</span></span>
<span class="line"><span style="color:#A6ACCD;">            </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">event</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">pages </span><span style="color:#89DDFF;">=</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">event</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">pages</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">filter</span><span style="color:#89DDFF;">(</span><span style="color:#C792EA;">function</span><span style="color:#89DDFF;">($</span><span style="color:#A6ACCD;">page</span><span style="color:#89DDFF;">)</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">{</span></span>
<span class="line"><span style="color:#A6ACCD;">                </span><span style="color:#89DDFF;">return</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">page</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">handle </span><span style="color:#89DDFF;">!==</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">workpage</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">;</span></span>
<span class="line"><span style="color:#A6ACCD;">            </span><span style="color:#89DDFF;">});</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">}</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#89DDFF;">}</span></span>
<span class="line"><span style="color:#89DDFF;">);</span></span>
<span class="line"></span></code></pre></div><div class="language-php"><button title="Copy Code" class="copy"></button><span class="lang">php</span><pre class="shiki"><code><span class="line"><span style="color:#FFCB6B;">Event</span><span style="color:#89DDFF;">::</span><span style="color:#82AAFF;">on</span><span style="color:#89DDFF;">(</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#FFCB6B;">Section</span><span style="color:#89DDFF;">::</span><span style="color:#F78C6C;">class</span><span style="color:#89DDFF;">,</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#FFCB6B;">Section</span><span style="color:#89DDFF;">::</span><span style="color:#A6ACCD;">EVENT_DEFINE_ACTIONS</span><span style="color:#89DDFF;">,</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#C792EA;">function</span><span style="color:#89DDFF;">(</span><span style="color:#FFCB6B;">DefineActionsEvent</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">event</span><span style="color:#89DDFF;">)</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">{</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">event</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">actions </span><span style="color:#89DDFF;">=</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">event</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">actions</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">filter</span><span style="color:#89DDFF;">(</span><span style="color:#C792EA;">function</span><span style="color:#89DDFF;">($</span><span style="color:#A6ACCD;">action</span><span style="color:#89DDFF;">)</span><span style="color:#A6ACCD;"> </span><span style="color:#F78C6C;">use</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">($</span><span style="color:#A6ACCD;">event</span><span style="color:#89DDFF;">)</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">{</span></span>
<span class="line"><span style="color:#A6ACCD;">            </span><span style="color:#89DDFF;">if</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">($</span><span style="color:#A6ACCD;">action </span><span style="color:#89DDFF;">instanceof</span><span style="color:#A6ACCD;"> </span><span style="color:#FFCB6B;">Action</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&amp;&amp;</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">action</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">handle </span><span style="color:#89DDFF;">===</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">publishAction</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">{</span></span>
<span class="line"><span style="color:#A6ACCD;">                </span><span style="color:#89DDFF;">return</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">event</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">entry</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">status </span><span style="color:#89DDFF;">!==</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">live</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">;</span></span>
<span class="line"><span style="color:#A6ACCD;">            </span><span style="color:#89DDFF;">}</span></span>
<span class="line"><span style="color:#A6ACCD;">            </span><span style="color:#89DDFF;">return</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">true;</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">});</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#89DDFF;">}</span></span>
<span class="line"><span style="color:#89DDFF;">);</span></span>
<span class="line"></span></code></pre></div><h2 id="modify-settings-for-current-user" tabindex="-1">Modify Settings for Current User <a class="header-anchor" href="#modify-settings-for-current-user" aria-hidden="true">#</a></h2><p>Sometimes it makes sense to modify plugin settings for the current user, based on their role or preferences.</p><p>Currently implemented for the <code>replaceDashboard</code>, <code>showPages</code>, <code>enableCreateInSlideoutEditor</code> settings.</p><p>The event contains <code>$key</code> and <code>$value</code> properties.</p><div class="language-php"><button title="Copy Code" class="copy"></button><span class="lang">php</span><pre class="shiki"><code><span class="line"><span style="color:#FFCB6B;">Event</span><span style="color:#89DDFF;">::</span><span style="color:#82AAFF;">on</span><span style="color:#89DDFF;">(</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#FFCB6B;">Settings</span><span style="color:#89DDFF;">::</span><span style="color:#F78C6C;">class</span><span style="color:#89DDFF;">,</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#FFCB6B;">Settings</span><span style="color:#89DDFF;">::</span><span style="color:#A6ACCD;">EVENT_DEFINE_USER_SETTING</span><span style="color:#89DDFF;">,</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#C792EA;">function</span><span style="color:#89DDFF;">(</span><span style="color:#FFCB6B;">DefineUserSettingEvent</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">event</span><span style="color:#89DDFF;">)</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">{</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">currentUser </span><span style="color:#89DDFF;">=</span><span style="color:#A6ACCD;"> </span><span style="color:#FFCB6B;">Craft</span><span style="color:#89DDFF;">::$</span><span style="color:#A6ACCD;">app</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">user</span><span style="color:#89DDFF;">;</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span></span>
<span class="line"><span style="color:#89DDFF;">        </span><span style="color:#676E95;">// Give users a custom field so that they can decide whether to see links in the main nav or in sidebar</span></span>
<span class="line"><span style="color:#89DDFF;">        </span><span style="color:#676E95;">// depending on their screen size</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">if</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">($</span><span style="color:#A6ACCD;">event</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">key </span><span style="color:#89DDFF;">===</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">showPages</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">{</span></span>
<span class="line"><span style="color:#A6ACCD;">            </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">showPages </span><span style="color:#89DDFF;">=</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">currentUser</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">identity</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">showContentoverviewPages</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">value </span><span style="color:#89DDFF;">??</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">default</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">;</span></span>
<span class="line"><span style="color:#A6ACCD;">            </span><span style="color:#89DDFF;">if</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">($</span><span style="color:#A6ACCD;">showPages </span><span style="color:#89DDFF;">!==</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">default</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">{</span></span>
<span class="line"><span style="color:#A6ACCD;">                </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">event</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">value </span><span style="color:#89DDFF;">=</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">showPages</span><span style="color:#89DDFF;">;</span></span>
<span class="line"><span style="color:#A6ACCD;">            </span><span style="color:#89DDFF;">}</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">}</span></span>
<span class="line"></span>
<span class="line"><span style="color:#89DDFF;">        </span><span style="color:#676E95;">// Always show dashboard for admins</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">if</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">($</span><span style="color:#A6ACCD;">event</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">key </span><span style="color:#89DDFF;">===</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">replaceDashboard</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">{</span></span>
<span class="line"><span style="color:#A6ACCD;">            </span><span style="color:#89DDFF;">if</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">($</span><span style="color:#A6ACCD;">currentUser</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">getIsAdmin</span><span style="color:#89DDFF;">())</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">{</span></span>
<span class="line"><span style="color:#A6ACCD;">                </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">event</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">value </span><span style="color:#89DDFF;">=</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">false;</span></span>
<span class="line"><span style="color:#A6ACCD;">            </span><span style="color:#89DDFF;">}</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">}</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#89DDFF;">}</span></span>
<span class="line"><span style="color:#89DDFF;">);</span></span>
<span class="line"></span></code></pre></div><h2 id="define-images-icons" tabindex="-1">Define images/icons. <a class="header-anchor" href="#define-images-icons" aria-hidden="true">#</a></h2><p>See <a href="./../pagecontent/images.html">Images and Icons</a> for how to use <code>Section::EVENT_DEFINE_IMAGE</code>, <code>Section::EVENT_DEFINE_ICON</code> events.</p>`,25),e=[p];function t(c,r,D,F,y,C){return a(),n("div",null,e)}const d=s(o,[["render",t]]);export{A as __pageData,d as default};
