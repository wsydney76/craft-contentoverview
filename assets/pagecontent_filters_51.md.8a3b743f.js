import{_ as s,a as n,b as a,c as l}from"./chunks/selectize.1f6cd760.js";import{_ as p,c as o,o as e,a as t}from"./app.b8e59d6b.js";const g=JSON.parse(`{"title":"Filters","description":"","frontmatter":{},"headers":[{"level":2,"title":"By Field","slug":"by-field","link":"#by-field","children":[]},{"level":2,"title":"Status filter","slug":"status-filter","link":"#status-filter","children":[]},{"level":2,"title":"Custom filters","slug":"custom-filters","link":"#custom-filters","children":[]},{"level":2,"title":"Use 'selectize' for filters","slug":"use-selectize-for-filters","link":"#use-selectize-for-filters","children":[]}],"relativePath":"pagecontent/filters_51.md"}`),c={name:"pagecontent/filters_51.md"},r=t(`<h1 id="filters" tabindex="-1">Filters <a class="header-anchor" href="#filters" aria-hidden="true">#</a></h1><div class="warning custom-block"><p class="custom-block-title">WARNING</p><p>Using filters has changed in V 5.2. The methods described here are deprecated, but should still work.</p></div><h2 id="by-field" tabindex="-1">By Field <a class="header-anchor" href="#by-field" aria-hidden="true">#</a></h2><p>Entries can be filtered by a custom field value.</p><div class="language-php"><button title="Copy Code" class="copy"></button><span class="lang">php</span><pre class="shiki"><code><span class="line"><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">filters</span><span style="color:#89DDFF;">([</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">co</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">createFilter</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">field</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">,</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">topics</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">),</span></span>
<span class="line"></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">co</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">createFilter</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">field</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">,</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">assignedTo</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)</span><span style="color:#A6ACCD;">       </span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">label</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">Responsible</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">orderBy</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">lastName, firstName</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">),</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">co</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">createFilter</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">field</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">,</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">workflowStatus</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">),</span></span>
<span class="line"><span style="color:#89DDFF;">])</span></span>
<span class="line"></span></code></pre></div><p>Currently supported:</p><ul><li>Entries fields</li><li>Users fields</li><li>Option fields (Dropdown)</li></ul><p><img src="`+s+`" alt="Screenshot"></p><h2 id="status-filter" tabindex="-1">Status filter <a class="header-anchor" href="#status-filter" aria-hidden="true">#</a></h2><p>Filter by workflow/entry status.</p><div class="language-php"><button title="Copy Code" class="copy"></button><span class="lang">php</span><pre class="shiki"><code><span class="line"><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">co</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">createFilter</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">status</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)-&gt;</span><span style="color:#82AAFF;">label</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">Workflow</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)</span></span>
<span class="line"></span></code></pre></div><p><img src="`+n+`" alt="Screenshot"></p><p>Options are defined in the <code>statusFilterOptions</code> plugin setting.</p><h2 id="custom-filters" tabindex="-1">Custom filters <a class="header-anchor" href="#custom-filters" aria-hidden="true">#</a></h2><p>Additionally custom filters can be defined:</p><div class="language-php"><button title="Copy Code" class="copy"></button><span class="lang">php</span><pre class="shiki"><code><span class="line"><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">filters</span><span style="color:#89DDFF;">([</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">co</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">createFilter</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">custom</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">,</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">criticalreviews</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)</span><span style="color:#A6ACCD;"> </span><span style="color:#676E95;">// pseudo field handle to identify this filter in event handlers</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">label</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">Critical Reviews</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">options</span><span style="color:#89DDFF;">([</span></span>
<span class="line"><span style="color:#A6ACCD;">            </span><span style="color:#89DDFF;">[</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">label</span><span style="color:#89DDFF;">&#39;</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">=&gt;</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">Overdue</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">,</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">value</span><span style="color:#89DDFF;">&#39;</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">=&gt;</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">overdue</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">],</span></span>
<span class="line"><span style="color:#A6ACCD;">            </span><span style="color:#89DDFF;">[</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">label</span><span style="color:#89DDFF;">&#39;</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">=&gt;</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">Next week</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">,</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">value</span><span style="color:#89DDFF;">&#39;</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">=&gt;</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">nextweek</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">],</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">])</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#89DDFF;">])</span></span>
<span class="line"><span style="color:#A6ACCD;">])</span></span>
<span class="line"></span></code></pre></div><p><img src="`+a+`" alt="Screenshot"></p><p>Options can be set dynamically via an event:</p><div class="language-php"><button title="Copy Code" class="copy"></button><span class="lang">php</span><pre class="shiki"><code><span class="line"><span style="color:#F78C6C;">use</span><span style="color:#FFCB6B;"> </span><span style="color:#A6ACCD;">wsydney76</span><span style="color:#89DDFF;">\\</span><span style="color:#A6ACCD;">contentoverview</span><span style="color:#89DDFF;">\\</span><span style="color:#A6ACCD;">events</span><span style="color:#89DDFF;">\\</span><span style="color:#A6ACCD;">DefineCustomFilterOptionsEvent</span><span style="color:#89DDFF;">;</span></span>
<span class="line"><span style="color:#F78C6C;">use</span><span style="color:#FFCB6B;"> </span><span style="color:#A6ACCD;">wsydney76</span><span style="color:#89DDFF;">\\</span><span style="color:#A6ACCD;">contentoverview</span><span style="color:#89DDFF;">\\</span><span style="color:#A6ACCD;">models</span><span style="color:#89DDFF;">\\</span><span style="color:#A6ACCD;">Filter</span><span style="color:#89DDFF;">;</span></span>
<span class="line"><span style="color:#FFCB6B;">Event</span><span style="color:#89DDFF;">::</span><span style="color:#82AAFF;">on</span><span style="color:#89DDFF;">(</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#FFCB6B;">Filter</span><span style="color:#89DDFF;">::</span><span style="color:#F78C6C;">class</span><span style="color:#89DDFF;">,</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#FFCB6B;">Filter</span><span style="color:#89DDFF;">::</span><span style="color:#A6ACCD;">EVENT_DEFINE_CUSTOM_FILTER_OPTIONS</span><span style="color:#89DDFF;">,</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#C792EA;">function</span><span style="color:#89DDFF;">(</span><span style="color:#FFCB6B;">DefineCustomFilterOptionsEvent</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">event</span><span style="color:#89DDFF;">)</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">{</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">if</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">($</span><span style="color:#A6ACCD;">event</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">filter</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">handle </span><span style="color:#89DDFF;">===</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">criticalreviews</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">{</span></span>
<span class="line"><span style="color:#A6ACCD;">            </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">event</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">filter</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">options</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">prepend</span><span style="color:#89DDFF;">([</span></span>
<span class="line"><span style="color:#A6ACCD;">                </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">label</span><span style="color:#89DDFF;">&#39;</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">=&gt;</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">A new option</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">,</span></span>
<span class="line"><span style="color:#A6ACCD;">                </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">value</span><span style="color:#89DDFF;">&#39;</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">=&gt;</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">aNewOption</span><span style="color:#89DDFF;">&#39;</span></span>
<span class="line"><span style="color:#A6ACCD;">            </span><span style="color:#89DDFF;">])</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">;</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">}</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#89DDFF;">}</span></span>
<span class="line"><span style="color:#89DDFF;">);</span></span>
<span class="line"></span></code></pre></div><p>A custom module then can apply filter params to the section query in an event handler, e.g.</p><div class="language-php"><button title="Copy Code" class="copy"></button><span class="lang">php</span><pre class="shiki"><code><span class="line"></span>
<span class="line"><span style="color:#F78C6C;">use</span><span style="color:#FFCB6B;"> </span><span style="color:#A6ACCD;">wsydney76</span><span style="color:#89DDFF;">\\</span><span style="color:#A6ACCD;">contentoverview</span><span style="color:#89DDFF;">\\</span><span style="color:#A6ACCD;">events</span><span style="color:#89DDFF;">\\</span><span style="color:#A6ACCD;">FilterContentOverviewQueryEvent</span><span style="color:#89DDFF;">;</span></span>
<span class="line"><span style="color:#F78C6C;">use</span><span style="color:#FFCB6B;"> </span><span style="color:#A6ACCD;">wsydney76</span><span style="color:#89DDFF;">\\</span><span style="color:#A6ACCD;">contentoverview</span><span style="color:#89DDFF;">\\</span><span style="color:#A6ACCD;">models</span><span style="color:#89DDFF;">\\</span><span style="color:#A6ACCD;">Section</span><span style="color:#89DDFF;">;</span></span>
<span class="line"></span>
<span class="line"><span style="color:#89DDFF;">...</span></span>
<span class="line"></span>
<span class="line"><span style="color:#FFCB6B;">Event</span><span style="color:#89DDFF;">::</span><span style="color:#82AAFF;">on</span><span style="color:#89DDFF;">(</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#FFCB6B;">Section</span><span style="color:#89DDFF;">::</span><span style="color:#F78C6C;">class</span><span style="color:#89DDFF;">,</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#FFCB6B;">Section</span><span style="color:#89DDFF;">::</span><span style="color:#A6ACCD;">EVENT_FILTER_CONTENTOVERVIEW_QUERY</span><span style="color:#89DDFF;">,</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#C792EA;">function</span><span style="color:#89DDFF;">(</span><span style="color:#FFCB6B;">FilterContentOverviewQueryEvent</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">event</span><span style="color:#89DDFF;">)</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">{</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">if</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">($</span><span style="color:#A6ACCD;">event</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">handle </span><span style="color:#89DDFF;">===</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">criticalreviews</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">{</span></span>
<span class="line"><span style="color:#A6ACCD;">            </span><span style="color:#89DDFF;">switch</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">($</span><span style="color:#A6ACCD;">event</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">value</span><span style="color:#89DDFF;">)</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">{</span></span>
<span class="line"><span style="color:#A6ACCD;">                </span><span style="color:#89DDFF;">case</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">overdue</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">:</span></span>
<span class="line"><span style="color:#A6ACCD;">                </span><span style="color:#89DDFF;">{</span></span>
<span class="line"><span style="color:#A6ACCD;">                    </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">event</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#A6ACCD;">query</span></span>
<span class="line"><span style="color:#A6ACCD;">                        </span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">workflowStatus</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">inReview</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)</span></span>
<span class="line"><span style="color:#A6ACCD;">                        </span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">dueDate</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">&lt; now</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">);</span></span>
<span class="line"><span style="color:#A6ACCD;">                    </span><span style="color:#89DDFF;">break</span><span style="color:#89DDFF;">;</span></span>
<span class="line"><span style="color:#A6ACCD;">                </span><span style="color:#89DDFF;">}</span></span>
<span class="line"><span style="color:#A6ACCD;">                </span><span style="color:#89DDFF;">case</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">nextweek</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">:</span></span>
<span class="line"><span style="color:#A6ACCD;">                </span><span style="color:#89DDFF;">{</span></span>
<span class="line"><span style="color:#89DDFF;">                   </span><span style="color:#676E95;">// </span></span>
<span class="line"><span style="color:#A6ACCD;">                </span><span style="color:#89DDFF;">}</span></span>
<span class="line"><span style="color:#A6ACCD;">            </span><span style="color:#89DDFF;">}</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">}</span></span>
<span class="line"><span style="color:#A6ACCD;">          </span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#89DDFF;">}</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#89DDFF;">);</span></span>
<span class="line"></span></code></pre></div><p>Multiple filters can take up a lot of space if used together with search, so you can push them below or on top of the search:</p><div class="language-php"><button title="Copy Code" class="copy"></button><span class="lang">php</span><pre class="shiki"><code><span class="line"><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">filtersPosition</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">bottom</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)</span><span style="color:#A6ACCD;"> </span><span style="color:#676E95;">// top|bottom</span></span>
<span class="line"></span></code></pre></div><p>Matrix subfields can also be used as filters:</p><div class="language-php"><button title="Copy Code" class="copy"></button><span class="lang">php</span><pre class="shiki"><code><span class="line"><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">co</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">createFilter</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">field</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">,</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">streaming.streamingProvider</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)-&gt;</span><span style="color:#82AAFF;">orderBy</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">title</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)</span></span>
<span class="line"><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">co</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">createFilter</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">field</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">,</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">streaming.digitalMedium.streamingProvider</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)-&gt;</span><span style="color:#82AAFF;">orderBy</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">title</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)</span><span style="color:#A6ACCD;">                        </span></span>
<span class="line"></span></code></pre></div><p>Specify fields in the form <code>matrixFieldHandle.blockTypeHandle.subFieldHandle</code>.</p><p>If there is only one block type, you can use <code>matrixFieldHandle.subFieldHandle</code></p><h2 id="use-selectize-for-filters" tabindex="-1">Use &#39;selectize&#39; for filters <a class="header-anchor" href="#use-selectize-for-filters" aria-hidden="true">#</a></h2><p>Filters by default use a standard <code>select</code> input. For longer lists of options you may want to switch to a <code>selectize</code> input that allows searching.</p><div class="language-php"><button title="Copy Code" class="copy"></button><span class="lang">php</span><pre class="shiki"><code><span class="line"><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">useSelectize</span><span style="color:#89DDFF;">()</span></span>
<span class="line"></span></code></pre></div><p><img src="`+l+'" alt="Snapshot"></p><p>Selectize inputs have a slightly different visual appearance than standard selects, so it is not a very good idea to mix them.</p>',32),D=[r];function F(y,i,C,A,d,u){return e(),o("div",null,D)}const v=p(c,[["render",F]]);export{g as __pageData,v as default};