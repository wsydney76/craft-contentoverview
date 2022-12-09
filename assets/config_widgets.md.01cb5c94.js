import{_ as s,c as a,o as n,a as e}from"./app.e8f0dc17.js";const p="/craft-contentoverview/assets/widget.3e99e677.jpg",l="/craft-contentoverview/assets/widgetsettings.40bceb5b.jpg",g=JSON.parse('{"title":"Widgets","description":"","frontmatter":{},"headers":[{"level":2,"title":"Link Widget","slug":"link-widget","link":"#link-widget","children":[]},{"level":2,"title":"Tab Widget","slug":"tab-widget","link":"#tab-widget","children":[]}],"relativePath":"config/widgets.md"}'),o={name:"config/widgets.md"},t=e(`<h1 id="widgets" tabindex="-1">Widgets <a class="header-anchor" href="#widgets" aria-hidden="true">#</a></h1><p>A single tab can be used as dashboard widget.</p><p>Define them in a special <code>config/contentoverview/widgets.php</code> page config file.</p><div class="language-php"><button title="Copy Code" class="copy"></button><span class="lang">php</span><pre class="shiki"><code><span class="line"><span style="color:#89DDFF;">&lt;?</span><span style="color:#A6ACCD;">php</span></span>
<span class="line"></span>
<span class="line"><span style="color:#F78C6C;">use</span><span style="color:#FFCB6B;"> </span><span style="color:#A6ACCD;">wsydney76</span><span style="color:#89DDFF;">\\</span><span style="color:#A6ACCD;">contentoverview</span><span style="color:#89DDFF;">\\</span><span style="color:#A6ACCD;">services</span><span style="color:#89DDFF;">\\</span><span style="color:#A6ACCD;">ContentOverviewService</span><span style="color:#89DDFF;">;</span></span>
<span class="line"></span>
<span class="line"><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">co </span><span style="color:#89DDFF;">=</span><span style="color:#A6ACCD;"> </span><span style="color:#F78C6C;">new</span><span style="color:#A6ACCD;"> </span><span style="color:#FFCB6B;">ContentOverviewService</span><span style="color:#89DDFF;">();</span></span>
<span class="line"></span>
<span class="line"><span style="color:#89DDFF;">return</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">[</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">tabs</span><span style="color:#89DDFF;">&#39;</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">=&gt;</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">[</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">co</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">createTab</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">Site</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">,</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">require</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">tab1.php</span><span style="color:#89DDFF;">&#39;</span><span style="color:#A6ACCD;">)</span><span style="color:#89DDFF;">,</span></span>
<span class="line"><span style="color:#A6ACCD;">        </span><span style="color:#89DDFF;">$</span><span style="color:#A6ACCD;">co</span><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">createTab</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">News</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">,</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">require</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">tab2.php</span><span style="color:#89DDFF;">&#39;</span><span style="color:#A6ACCD;">)</span><span style="color:#89DDFF;">,</span></span>
<span class="line"><span style="color:#A6ACCD;">    ]</span></span>
<span class="line"><span style="color:#A6ACCD;">]</span><span style="color:#89DDFF;">;</span></span>
<span class="line"></span></code></pre></div><h2 id="link-widget" tabindex="-1">Link Widget <a class="header-anchor" href="#link-widget" aria-hidden="true">#</a></h2><p>There is a small dashboard widget, offering quick links to each tab of the overview page.</p><p><img src="`+p+'" alt="screenshot"></p><h2 id="tab-widget" tabindex="-1">Tab Widget <a class="header-anchor" href="#tab-widget" aria-hidden="true">#</a></h2><p>A single tab can be shown in a dashboad widget. Available tabs are defined in <code>widgets.php</code> page.</p><p><img src="'+l+'" alt="screenshot"></p>',10),c=[t];function r(i,D,F,d,y,C){return n(),a("div",null,c)}const h=s(o,[["render",r]]);export{g as __pageData,h as default};
