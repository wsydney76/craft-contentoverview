<?php

namespace wsydney76\contentoverview;

use Craft;
use craft\base\Model;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterCpNavItemsEvent;
use craft\events\RegisterTemplateRootsEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\events\RegisterUserPermissionsEvent;
use craft\helpers\App;
use craft\services\Dashboard;
use craft\services\Plugins;
use craft\services\UserPermissions;
use craft\web\twig\variables\Cp;
use craft\web\twig\variables\CraftVariable;
use craft\web\UrlManager;
use craft\web\View;
use wsydney76\contentoverview\assets\ContentOverviewAssetBundle;
use wsydney76\contentoverview\assets\WorkPluginAssetBundle;
use wsydney76\contentoverview\models\Settings;
use wsydney76\contentoverview\services\ContentOverviewService;
use wsydney76\contentoverview\variables\ContentOverviewVariable;
use wsydney76\contentoverview\widgets\ContentOverviewLinksWidget;
use wsydney76\contentoverview\widgets\ContentOverviewTabWidget;
use wsydney76\elementmap\assets\ElementMapBundle;
use yii\base\Event;
use function array_merge;
use function array_splice;

/**
 * @property ContentOverviewService $contentoverview
 */
class Plugin extends \craft\base\Plugin
{

    public function init()
    {
        parent::init();


        // Defer most setup tasks until Craft is fully initialized
        Craft::$app->onInit(function() {
            $this->initPlugin();
            // ...
        });
    }

    public function initPlugin()
    {

        parent::init();

        /** @var Settings $settings */
        $settings = $this->getSettings();

        if (!Craft::$app->request->isCpRequest) {
            return;
        }

        // Do not crash on login page
        $currentUser = Craft::$app->user->identity;
        if (!$currentUser) {
            return;
        }

        if (!$currentUser->can('accessPlugin-contentoverview')) {
            return;
        }

        $this->setAliases(
            ['@coicons' => $this->basePath . '/icons']
        );

        $this->setComponents([
            'contentoverview' => $settings->serviceClass
        ]);


        Event::on(
            View::class,
            View::EVENT_REGISTER_CP_TEMPLATE_ROOTS,
            function(RegisterTemplateRootsEvent $event) {
                $event->roots['_contentoverview'] = App::parseEnv($this->getSettings()->customTemplateRoot);
            }
        );

        $showPages = $settings->getUserSetting('showPages');

        if ($showPages === 'nav' || $showPages === 'sidebar') {
            Event::on(
                Cp::class,
                Cp::EVENT_REGISTER_CP_NAV_ITEMS,
                function(RegisterCpNavItemsEvent $event) use ($settings, $showPages) {

                    $pages = $this->contentoverview->getPages();

                    // Nav item for top  level navigation
                    $navItem = [
                        'label' => Craft::t('site', $settings->pluginTitle),
                        'url' => 'contentoverview',
                        'fontIcon' => 'field'
                    ];

                    // Do we have a subnav?
                    if ($pages->count() > 1 && $showPages === 'nav') {

                        $navItem['subnav'] = $pages
                            // Do not include pages without url (group headings)
                            ->filter(fn($page) => $page->url)

                            // convert into format that 'subnav' needs.
                            // Has to include a key that can be used for the 'selectedSubNav' twig variable.
                            ->mapWithKeys(fn($page) => [
                                $page->pageKey => [
                                    // Translate labels
                                    'label' => Craft::t('site', $page['label']),
                                    'url' => $page->url,
                                ]
                            ]);
                    }

                    // Insert into navItems at second position, after dashboard.
                    array_splice($event->navItems, 1, 0, [
                        $navItem
                    ]);
                }
            );
        }

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES, function(RegisterUrlRulesEvent $event) {
            $event->rules = array_merge($event->rules, [
                'contentoverview' => 'contentoverview/page',
                'contentoverview/<pageKey:{slug}>' => 'contentoverview/page'
            ]);
        });

        Event::on(
            Dashboard::class,
            Dashboard::EVENT_REGISTER_WIDGET_TYPES,
            function(RegisterComponentTypesEvent $event) use ($settings) {
                $event->types[] = ContentOverviewLinksWidget::class;
                if ($settings->enableWidgets) {
                    $event->types[] = ContentOverviewTabWidget::class;
                }
            }
        );

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function(Event $event) {
                $event->sender->set('contentoverview', ContentOverviewVariable::class);
            }
        );

        // Create Permissions
        Event::on(
            UserPermissions::class,
            UserPermissions::EVENT_REGISTER_PERMISSIONS, function(RegisterUserPermissionsEvent $event) use ($settings) {
            $event->permissions['Content Overview'] = [
                'heading' => 'Content Overview Plugin',
                'permissions' => array_merge(
                    [
                        'accessPlugin-contentoverview' => [
                            'label' => Craft::t('contentoverview', 'Access Content Overview Plugin'),
                        ]
                    ],
                    [
                        'superUser-contentoverview' => [
                            'label' => Craft::t('contentoverview', 'Can view everything (all pages, tabs, columns, sections)'),
                        ]
                    ]
                    , $settings->extraPermissions)
            ];
        });

        // Replace dashboard?
        if ($settings->getUserSetting('replaceDashboard')) {
            if (Craft::$app->getRequest()->getSegment(1) === 'dashboard') {
                Craft::$app->getResponse()->redirect('contentoverview');
            }

            Event::on(View::class, View::EVENT_BEFORE_RENDER_TEMPLATE,
                function() {
                    Craft::$app->getView()->registerCss('#nav-dashboard {display: none !important;}');
                }
            );
        }

        // Register CSS an JS
        Craft::$app->view->registerAssetBundle(ContentOverviewAssetBundle::class);


        if (Craft::$app->plugins->isPluginEnabled('work')) {
            Craft::$app->view->registerAssetBundle(WorkPluginAssetBundle::class);
        }
        if (Craft::$app->plugins->isPluginEnabled('elementmap')) {
            Craft::$app->view->registerAssetBundle(ElementMapBundle::class);
        }
    }

    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }


}