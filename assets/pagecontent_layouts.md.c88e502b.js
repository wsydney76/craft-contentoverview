import{_ as s,c as a,o as l,a as n}from"./app.b8e59d6b.js";const e="/craft-contentoverview/assets/layout_cards.6a1e5981.jpg",t="/craft-contentoverview/assets/tinysection.0c749033.jpg",o="/craft-contentoverview/assets/layout_cardlets.fd2960e9.jpg",p="/craft-contentoverview/assets/layout_list.aa1ad1c2.jpg",c="/craft-contentoverview/assets/layout_line.25acc192.jpg",r="/craft-contentoverview/assets/tablelayout.204715fb.jpg",f=JSON.parse('{"title":"Layouts","description":"","frontmatter":{},"headers":[{"level":2,"title":"Cards","slug":"cards","link":"#cards","children":[{"level":3,"title":"Size and image aspect ratio","slug":"size-and-image-aspect-ratio","link":"#size-and-image-aspect-ratio","children":[]}]},{"level":2,"title":"Cardlets","slug":"cardlets","link":"#cardlets","children":[]},{"level":2,"title":"List","slug":"list","link":"#list","children":[]},{"level":2,"title":"Line","slug":"line","link":"#line","children":[]},{"level":2,"title":"Table","slug":"table","link":"#table","children":[]}],"relativePath":"pagecontent/layouts.md"}'),i={name:"pagecontent/layouts.md"},F=n('<h1 id="layouts" tabindex="-1">Layouts <a class="header-anchor" href="#layouts" aria-hidden="true">#</a></h1><p>Entries can be shown in different layouts.</p><p>List and line layouts can show indentations for different levels in a structure.</p><h2 id="cards" tabindex="-1">Cards <a class="header-anchor" href="#cards" aria-hidden="true">#</a></h2><p>A vertical layout that puts emphasis on an image and allows unlimited multi line content.</p><p><img src="'+e+`" alt="Layout Cards"></p><h3 id="size-and-image-aspect-ratio" tabindex="-1">Size and image aspect ratio <a class="header-anchor" href="#size-and-image-aspect-ratio" aria-hidden="true">#</a></h3><p>The visual impression of a card is highly depending on the type of image and the content/actions (e.g. typical length of title) in it.</p><p>So you may want to change the grid column width and the aspect ratio of the image for a better experience.</p><p>For example, for a person directory a smaller width and a portrait mode will be better:</p><div class="language-php"><button title="Copy Code" class="copy"></button><span class="lang">php</span><pre class="shiki"><code><span class="line"><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">size</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">tiny</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)</span></span>
<span class="line"><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">imageRatio</span><span style="color:#89DDFF;">(</span><span style="color:#F78C6C;">4</span><span style="color:#89DDFF;">/</span><span style="color:#F78C6C;">5</span><span style="color:#89DDFF;">)</span></span>
<span class="line"></span></code></pre></div><p><img src="`+t+'" alt="Screenshot"></p><h2 id="cardlets" tabindex="-1">Cardlets <a class="header-anchor" href="#cardlets" aria-hidden="true">#</a></h2><p>A more compact layout, less space for info</p><p><img src="'+o+'" alt="Layout Cardlets"></p><p>A size section config setting can be applied.</p><h2 id="list" tabindex="-1">List <a class="header-anchor" href="#list" aria-hidden="true">#</a></h2><p>Horizontal layout, keep info on one line!</p><p><img src="'+p+'" alt="Layout List"></p><h2 id="line" tabindex="-1">Line <a class="header-anchor" href="#line" aria-hidden="true">#</a></h2><p>Horizontal layout without image. The most compact layout.</p><p><img src="'+c+'" alt="Layout Line"></p><p>Do not specify an <code>imageField</code> for this layout.</p><h2 id="table" tabindex="-1">Table <a class="header-anchor" href="#table" aria-hidden="true">#</a></h2><p>A table with multiple columns.</p><p><img src="'+r+`" alt="Screenshot"></p><div class="language-php"><button title="Copy Code" class="copy"></button><span class="lang">php</span><pre class="shiki"><code><span class="line"><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">co</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">createTableSection</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">News</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">,</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">[</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">co</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">createTableColumn</span><span style="color:#89DDFF;">()</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">label</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">Tagline</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">value</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">{tagline}</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">),</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">co</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">createTableColumn</span><span style="color:#89DDFF;">()</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">label</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">PostDate</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">value</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">{postDate|date(&quot;short&quot;)}</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">),</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">co</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">createTableColumn</span><span style="color:#89DDFF;">()</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">label</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">Workflow</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">template</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">_contentoverview/columns/workflow.twig</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)</span></span>
<span class="line"><span style="color:#89DDFF;">])</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">section</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">news</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)</span></span>
<span class="line"><span style="color:#89DDFF;">    </span><span style="color:#676E95;">// all section config settings are available here</span></span>
<span class="line"></span></code></pre></div><p>Available settings:</p><ul><li>TableSection <ul><li>showImage (bool, whether to show the image column)</li><li>showStatus (bool, whether to show the status column)</li><li>showTitle (bool, whether to show the title column)</li><li>columns[] (array of TableColumns models) <ul><li>label (string, column heading)</li><li>value (string, an object template) or:</li><li>template (string, a custom twig template, an <code>entry</code> variable will be available)</li><li>align (string, left (default)|right, alignment of the column content)</li></ul></li></ul></li></ul><p>A <code>TableSection::EVENT_DEFINE_TABLECOLUMNS</code> event is available if you want to taylor the columns.</p>`,30),D=[F];function y(d,h,u,g,m,A){return l(),a("div",null,D)}const b=s(i,[["render",y]]);export{f as __pageData,b as default};