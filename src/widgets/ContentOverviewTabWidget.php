<?php

namespace wsydney76\contentoverview\widgets;

use Craft;
use craft\base\Widget;
use craft\helpers\Cp;
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
        $page = Plugin::getInstance()->contentoverview->createPage('widgets', ['label' => 'Widgets']);

        if (!$this->tabId) {
            return self::displayName();
        }

        $tabConfig = $page->getTabConfig($this->tabId);
        if (!$tabConfig['tab']) {
            return self::displayName();
        }

        return $tabConfig['tab']['label'];
    }

    public function getSettingsHtml(): ?string
    {
        $page = Plugin::getInstance()->contentoverview->createPage('widgets', ['label' => 'Widgets']);

        return Cp::selectFieldHtml([
                'label' => Craft::t('contentoverview', 'Tab'),
                'id' => 'tabId',
                'name' => 'tabId',
                'value' => $this->tabId,
                'errors' => $this->getErrors('tabId'),
                'options' => $page->getTabs()->map(fn($tab) => [
                    'label' => $tab->label,
                    'value' => $tab->getId()
                ])
            ]) .

            Cp::selectFieldHtml([
                'label' => Craft::t('contentoverview', 'Optimize grid for this number of columns (Legacy Browsers only)'),
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

        $page = Plugin::getInstance()->contentoverview->createPage('widgets', ['label' => 'Widgets']);

        $tabConfig = $page->getTabConfig($this->tabId);

        return Craft::$app->view->renderTemplate('contentoverview/widgets/tabwidget.twig', [
            'tab' => $tabConfig['tab'],
            'tabIndex' => $tabConfig['tabIndex'],
            'settings' => $settings,
            'cols' => $this->cols,
            'page' => $page
        ]);
    }

}