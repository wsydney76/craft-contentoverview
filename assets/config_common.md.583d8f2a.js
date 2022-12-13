import{_ as s,c as a,o as n,a as e}from"./app.10bb4439.js";const D=JSON.parse('{"title":"Common settings","description":"","frontmatter":{},"headers":[{"level":2,"title":"handle","slug":"handle","link":"#handle","children":[]},{"level":2,"title":"custom","slug":"custom","link":"#custom","children":[]},{"level":2,"title":"permission","slug":"permission","link":"#permission","children":[]},{"level":2,"title":"group","slug":"group","link":"#group","children":[]},{"level":2,"title":"loadSectionsAsync","slug":"loadsectionsasync","link":"#loadsectionsasync","children":[]}],"relativePath":"config/common.md"}'),l={name:"config/common.md"},o=e(`<h1 id="common-settings" tabindex="-1">Common settings <a class="header-anchor" href="#common-settings" aria-hidden="true">#</a></h1><p>The following settings can be applied to every object (page/tab/column/section/filter/action...)</p><h2 id="handle" tabindex="-1">handle <a class="header-anchor" href="#handle" aria-hidden="true">#</a></h2><ul><li>Type: <code>string</code></li></ul><p>A handle that helps to identify the object in events/custom templates.</p><div class="language-php"><button title="Copy Code" class="copy"></button><span class="lang">php</span><pre class="shiki"><code><span class="line"><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">handle</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">pendingReviews</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)</span></span>
<span class="line"></span></code></pre></div><h2 id="custom" tabindex="-1">custom <a class="header-anchor" href="#custom" aria-hidden="true">#</a></h2><ul><li>Type: <code>array</code></li></ul><p>Can contain any data that you want to use in events/custom templates.</p><div class="language-php"><button title="Copy Code" class="copy"></button><span class="lang">php</span><pre class="shiki"><code><span class="line"><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">custom</span><span style="color:#89DDFF;">([</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">key</span><span style="color:#89DDFF;">&#39;</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">=&gt;</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">value</span><span style="color:#89DDFF;">&#39;</span></span>
<span class="line"><span style="color:#89DDFF;">])</span></span>
<span class="line"></span></code></pre></div><h2 id="permission" tabindex="-1">permission <a class="header-anchor" href="#permission" aria-hidden="true">#</a></h2><ul><li>Type: <code>string</code></li></ul><p>Only admins and users with this permission will see this object.</p><div class="language-php"><button title="Copy Code" class="copy"></button><span class="lang">php</span><pre class="shiki"><code><span class="line"><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">permission</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">yourCustomPermission</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)</span></span>
<span class="line"></span></code></pre></div><h2 id="group" tabindex="-1">group <a class="header-anchor" href="#group" aria-hidden="true">#</a></h2><ul><li>Type: <code>string|array</code></li></ul><p>Only admins and members of this group/one of these groups will see this object. Will be ignored if the more specific <code>permission</code> is set.</p><div class="language-php"><button title="Copy Code" class="copy"></button><span class="lang">php</span><pre class="shiki"><code><span class="line"><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">group</span><span style="color:#89DDFF;">(</span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">festivalEditors</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">)</span></span>
<span class="line"></span></code></pre></div><h2 id="loadsectionsasync" tabindex="-1">loadSectionsAsync <a class="header-anchor" href="#loadsectionsasync" aria-hidden="true">#</a></h2><div class="language-php"><button title="Copy Code" class="copy"></button><span class="lang">php</span><pre class="shiki"><code><span class="line"><span style="color:#89DDFF;">-&gt;</span><span style="color:#82AAFF;">loadSectionsAsync</span><span style="color:#89DDFF;">()</span></span>
<span class="line"></span></code></pre></div><p>Whether to load section html via ajax request.</p><p>If applied on page or tab level, all contained sections will be loaded asynchronous.</p><p>Can also be enabled <a href="./plugin-config.html#loadsectionsasync">globally</a>.</p>`,23),p=[o];function t(c,i,r,d,h,y){return n(),a("div",null,p)}const F=s(l,[["render",t]]);export{D as __pageData,F as default};
