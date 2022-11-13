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
use craft\services\UserPermissions;
use craft\web\twig\variables\Cp;
use craft\web\twig\variables\CraftVariable;
use craft\web\UrlManager;
use craft\web\View;
use wsydney76\contentoverview\assets\ContentOverviewAssetBundle;
use wsydney76\contentoverview\models\Settings;
use wsydney76\contentoverview\services\ContentOverviewService;
use wsydney76\contentoverview\variables\ContentOverviewVariable;
use wsydney76\contentoverview\widgets\ContentOverviewLinksWidget;
use wsydney76\contentoverview\widgets\ContentOverviewTabWidget;
use yii\base\Event;
use function array_splice;
use function getenv;

class Plugin extends \craft\base\Plugin
{

    // Disable for now because of possible conflicts
    public bool $hasCpSettings = false;

    public function init()
    {
        parent::init();

        if (!Craft::$app->request->isCpRequest) {
            return;
        }

        $this->setComponents([
            'co' => ContentOverviewService::class
        ]);


        Event::on(
            View::class,
            View::EVENT_REGISTER_CP_TEMPLATE_ROOTS,
            function(RegisterTemplateRootsEvent $event) {
                $event->roots['_contentoverview'] =  App::parseEnv("@templates/{$this->getSettings()->customTemplatePath}");
            }
        );


        /** @var Settings $settings */
        $settings = $this->getSettings();


        if ($settings->enableNav) {
            Event::on(
                Cp::class,
                Cp::EVENT_REGISTER_CP_NAV_ITEMS,
                function(RegisterCpNavItemsEvent $event) use ($settings) {

                    $navItem = [
                        'label' => Craft::t('site', $settings->pluginTitle),
                        'url' => 'contentoverview',
                        'fontIcon' => 'field'
                    ];

                    if ($settings->getPages()->count() > 1) {
                        // Translate labels
                        $navItem['subnav'] = $settings->getPages()->transform(fn ($page) => [
                            'label' => Craft::t('site', $page['label']),
                            'url' => $page['url']
                        ]);
                    }

                    // \Craft::dd($navItem);

                    array_splice($event->navItems, 1, 0, [
                        $navItem
                    ]);
                }
            );

            Event::on(
                UrlManager::class,
                UrlManager::EVENT_REGISTER_CP_URL_RULES, function(RegisterUrlRulesEvent $event) {
                $event->rules = array_merge($event->rules, [
                    'contentoverview/<page:{slug}>' => ['template' => 'contentoverview/index']
                ]);
            }
            );
        }

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
            UserPermissions::EVENT_REGISTER_PERMISSIONS, function(RegisterUserPermissionsEvent $event) {
            $event->permissions['Content Overview'] = [
                'heading' => 'Content Overview Plugin',
                'permissions' => [
                    'accessPlugin-contentoverview' => [
                        'label' => Craft::t('contentoverview', 'Access Content Overview Plugin'),
                    ]
                ]

            ];
        });

        Craft::$app->view->registerAssetBundle(ContentOverviewAssetBundle::class);
    }

    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }

    protected function settingsHtml(): ?string
    {
        return Craft::$app->view->renderTemplate(
            'contentoverview/settings.twig',
            ['settings' => $this->getSettings()]
        );
    }

}