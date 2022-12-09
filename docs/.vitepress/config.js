/**
 * @type {import('vitepress').UserConfig}
 */

const $config = {
    title: 'Content Overview',
    description: 'Content Overview Craft Plugin',
    base: '/craft-contentoverview/',
    themeConfig: {
        logo: '/wsydney76.jpg',
        socialLinks: [
            {icon: 'github', link: 'https://github.com/wsydney76/craft-contentoverview'},
        ],
        outline: 'deep',
        nav: [
            {text: 'Changelog', link: 'https://github.com/wsydney76/craft-contentoverview/blob/main/CHANGELOG.md'}
        ],
        sidebar: [
            {
                text: 'Configuration',
                collapsible: true,
                items: [
                    {text: 'Plugin Config', link: '/config/plugin-config'},
                    {text: 'Common Settings', link: '/config/common'},
                    {text: 'Pages Setup', link: '/config/pages-setup'},
                    {text: 'Page Config', link: '/config/page-config'},
                    {text: 'Section Settings', link: '/config/section-settings'},
                    {text: 'Widgets', link: '/config/widgets'},
                    {text: 'Craft general config', link: '/config/craft'},
                ]
            },
            {
                text: 'On Your Page',
                collapsible: true,
                items: [
                    {text: 'Layouts', link: '/pagecontent/layouts'},
                    {text: 'Images and Icons', link: '/pagecontent/images'},
                    {text: 'Searching', link: '/pagecontent/search'},
                    {text: 'Sorting', link: '/pagecontent/sorting'},
                    {text: 'Filters', link: '/pagecontent/filters'},
                    {text: 'Actions', link: '/pagecontent/actions'},
                    {text: 'Help', link: '/pagecontent/help'},
                ]
            },
            {
                text: 'Customize',
                collapsible: true,
                items: [
                    {text: 'Overwrite templates', link: '/customize/templates'},
                    {text: 'Custom Sections', link: '/customize/customsections'},
                    {text: 'Widget Sections', link: '/customize/widgetsections'},
                    {text: 'Twig Blocks', link: '/customize/twigblocks'},
                    {text: 'Overwrite classes', link: '/customize/overwriteclasses'},
                    {text: 'Example', link: '/customize/customizationexample'},
                    {text: 'Events', link: '/customize/events'},
                ]
            },
            {
                text: 'Misc.',
                collapsible: true,
                items: [
                    {text: 'Permissions', link: '/misc/permissions'},
                    {text: 'Translations', link: '/misc/translations'},
                    {text: 'Integrations', link: '/misc/integrations'},
                    {text: 'Performance', link: '/misc/performance'},
                    {text: 'Security', link: '/misc/security'},
                ]
            }
        ]
    }
}

export default $config