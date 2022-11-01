<?php

namespace wsydney76\contentoverview;

use Craft;
use craft\base\Model;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterCpNavItemsEvent;
use craft\services\Dashboard;
use craft\web\twig\variables\Cp;
use craft\web\twig\variables\CraftVariable;
use wsydney76\contentoverview\models\Settings;
use wsydney76\contentoverview\variables\ContentOverviewVariable;
use wsydney76\contentoverview\widgets\ContentOverviewWidget;
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


        if ($settings->display === 'nav') {

            $this->registerNavItem([
                'label' => Craft::t('contentoverview', 'Content Overview'),
                'url' => 'contentoverview',
                'fontIcon' => 'field'
            ], 1);
        } elseif ($settings->display === 'widget') {
            $this->registerWidgetTypes([
                ContentOverviewWidget::class
            ]);
        }

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function(Event $event) {
                $event->sender->set('contentoverview', ContentOverviewVariable::class);
            }
        );
    }

    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }

    protected function registerNavItem(array $navItem, $pos = null)
    {
        Event::on(
            Cp::class,
            Cp::EVENT_REGISTER_CP_NAV_ITEMS,
            function(RegisterCpNavItemsEvent $event) use ($navItem, $pos) {
                if ($pos) {
                    array_splice($event->navItems, $pos, 0, [$navItem]);
                } else {
                    $event->navItems[] = $navItem;
                }
            }
        );
    }

    protected function registerWidgetTypes(array $widgetTypes): void
    {
        Event::on(
            Dashboard::class,
            Dashboard::EVENT_REGISTER_WIDGET_TYPES,
            function(RegisterComponentTypesEvent $event) use ($widgetTypes) {
                foreach ($widgetTypes as $widgetType) {
                    $event->types[] = $widgetType;
                }
            }
        );
    }
}