<?php

namespace wsydney76\contentoverview\widgets;

use Craft;
use craft\base\Widget;
use craft\helpers\Cp;
use craft\helpers\StringHelper;
use wsydney76\contentoverview\Plugin;


class ContentOverviewTabWidget extends Widget
{
    public string $tabId = '';
    public string $cols = 'full';

    public static function displayName(): string
    {
        return Craft::t('contentoverview', 'Content Overview');
    }

    public static function icon(): ?string
    {
        return '@appicons/field.svg';
    }

    protected static function allowMultipleInstances(): bool
    {
        return true;
    }

    public function getTitle(): ?string
    {
        if (!$this->tabId) {
            return self::displayName();
        }

        $tabConfig = Plugin::getInstance()->getSettings()->getTabConfig('widgets', $this->tabId);
        if (!$tabConfig) {
            return self::displayName();
        }

        return $tabConfig['label'];
    }

    public function getSettingsHtml(): ?string
    {
        return Cp::selectFieldHtml([
                'label' => Craft::t('contentoverview', 'Tab'),
                'id' => 'tabId',
                'name' => 'tabId',
                'value' => $this->tabId,
                'errors' => $this->getErrors('tabId'),
                'options' => Plugin::getInstance()->getSettings()->getTabs('widgets')->map(function ($tab) {
                    return [
                        'label' => $tab->label,
                        'value' => $tab->getId()
                    ];
                })
            ]) .

            Cp::selectFieldHtml([
                'label' => Craft::t('contentoverview', 'Optimize grid for this number of columns'),
                'id' => 'cols',
                'name' => 'cols',
                'value' => $this->cols,
                'errors' => $this->getErrors('cols'),
                'instructions' => Craft::t('contentoverview',
                    'Widget must be at least two columns wide if "Two" is selected, or at least four columns if "All" is selected'),
                'options' => [
                    ['label' => Craft::t('contentoverview', 'Two (half width)'), 'value' => 'half'],
                    ['label' => Craft::t('contentoverview', 'All (full width)'), 'value' => 'full'],
                ]
            ]);
    }

    public function getBodyHtml(): ?string
    {
        $settings = Plugin::getInstance()->getSettings();

        return Craft::$app->view->renderTemplate('contentoverview/widgets/tabwidget.twig', [
            'tab' => $settings->getTabConfig('widgets', $this->tabId),
            'settings' => $settings,
            'cols' => $this->cols
        ]);
    }

}