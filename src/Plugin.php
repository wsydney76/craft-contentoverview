<?php

namespace wsydney76\contentoverview;

use Craft;
use craft\base\Model;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterCpNavItemsEvent;
use craft\events\RegisterUserPermissionsEvent;
use craft\services\Dashboard;
use craft\services\UserPermissions;
use craft\web\twig\variables\Cp;
use craft\web\twig\variables\CraftVariable;
use wsydney76\contentoverview\models\Settings;
use wsydney76\contentoverview\variables\ContentOverviewVariable;
use wsydney76\contentoverview\widgets\ContentOverviewLinksWidget;
use wsydney76\contentoverview\widgets\ContentOverviewTabWidget;
use yii\base\Event;
use function array_splice;

class Plugin extends \craft\base\Plugin
{

    public function init()
    {
        parent::init();

        if (!Craft::$app->request->isCpRequest) {
            return;
        }

        /** @var Settings $settings */
        $settings = $this->getSettings();


        if ($settings->enableNav) {
            Event::on(
                Cp::class,
                Cp::EVENT_REGISTER_CP_NAV_ITEMS,
                function(RegisterCpNavItemsEvent $event) use ($settings) {
                    array_splice($event->navItems, 1, 0, [
                        [
                            'label' => Craft::t('contentoverview', $settings->navLabel),
                            'url' => 'contentoverview',
                            'fontIcon' => 'field'
                        ]
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

        Craft::$app->view->registerAssetBundle('wsydney76\\contentoverview\\assets\\ContentOverviewAssetBundle');
    }

    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }

}