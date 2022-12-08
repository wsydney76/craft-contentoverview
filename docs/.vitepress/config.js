export default {
    title: 'Content Overview',
    description: 'A Craft CMS plugin',
    base: '/craft-contentoverview/',
    themeConfig: {
        logo: '/wsydney76.jpg',
        socialLinks: [
            {icon: 'github', link: 'https://github.com/wsydney76/craft-contentoverview'},
        ],
        sidebar: [
            {
                text: 'Configuration',
                collapsible: true,
                items: [
                    {text: 'Plugin Config', link: '/plugin-config'},
                    {text: 'Page Config', link: '/page-config'},
                ]
            }
        ]
    }
}