import{_ as e,c as a,o as t,a as s}from"./app.e8f0dc17.js";const y=JSON.parse('{"title":"Overwrite templates","description":"","frontmatter":{},"headers":[{"level":2,"title":"Variables","slug":"variables","link":"#variables","children":[]}],"relativePath":"customize/templates.md"}'),l={name:"customize/templates.md"},n=s(`<h1 id="overwrite-templates" tabindex="-1">Overwrite templates <a class="header-anchor" href="#overwrite-templates" aria-hidden="true">#</a></h1><p>All twig templates are called like so:</p><div class="language-php"><button title="Copy Code" class="copy"></button><span class="lang">php</span><pre class="shiki"><code><span class="line"><span style="color:#89DDFF;">{%</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">include</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">[</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">_contentoverview/partials/entry.twig</span><span style="color:#89DDFF;">&#39;</span><span style="color:#89DDFF;">,</span></span>
<span class="line"><span style="color:#A6ACCD;">    </span><span style="color:#89DDFF;">&#39;</span><span style="color:#C3E88D;">contentoverview/partials/entry.twig</span><span style="color:#89DDFF;">&#39;</span></span>
<span class="line"><span style="color:#89DDFF;">]</span><span style="color:#A6ACCD;"> </span><span style="color:#89DDFF;">%}</span></span>
<span class="line"></span></code></pre></div><p>where the template root <code>_contentoverview</code> by default points to your project&#39;s <code>templates/_contentoverview</code> folder.</p><p>This allows you to overwrite any twig template in case you have special needs.</p><p>Templates are included without an <code>only</code> parameter, making all variables available to them, because we know what our templates need, but maybe you need more in your templates.</p><p>Required params passed to a template should be listed in an <code>@params</code> comment (no guarantee).</p><h2 id="variables" tabindex="-1">Variables <a class="header-anchor" href="#variables" aria-hidden="true">#</a></h2><p>Generally available variables:</p><ul><li>settings - The plugin settings</li><li>page - The page object</li></ul><p>Variables available within a section:</p><ul><li>sectionConfig - The section object containing all section settings</li><li>sectionPath - A unique identifier of a section, enables ajax request to identify the section</li><li>sectionPageNo - The current page shown in the section</li><li>tab - the current tab object</li><li>column - the current column object</li></ul><p>Entry template and includes</p><ul><li>entry - You guessed it.</li></ul>`,14),o=[n];function i(p,r,c,d,u,h){return t(),a("div",null,o)}const _=e(l,[["render",i]]);export{y as __pageData,_ as default};
