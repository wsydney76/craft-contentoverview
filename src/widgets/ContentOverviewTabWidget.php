<?php

namespace wsydney76\contentoverview\widgets;

use Craft;
use craft\base\Widget;
use craft\helpers\Cp;
use wsydney76\contentoverview\Plugin;


class ContentOverviewTabWidget extends Widget
{
    public string $tabId = '';

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

        $tabConfig = Plugin::getInstance()->contentoverviewService->getTabConfig($this->tabId);
        if (!$tabConfig) {
            return self::displayName();
        }

        return $tabConfig['label'];
    }

    public function getSettingsHtml(): ?string
    {
        $settings = Plugin::getInstance()->getSettings();

        return Cp::selectFieldHtml([
            'label' => Craft::t('contentoverview', 'Tab'),
            'id' => 'tabId',
            'name' => 'tabId',
            'value' => $this->tabId,
            'errors' => $this->getErrors('tabId'),
            'options' => array_map(fn($tab) => [
                'label' => $tab['label'],
                'value' => $tab['id']
            ], $settings['tabs'])
        ]);
    }

    public function getBodyHtml(): ?string
    {
        return Craft::$app->view->renderTemplate('contentoverview/widgets/tabwidget.twig', [
            'tab' => Plugin::getInstance()->contentoverviewService->getTabConfig($this->tabId),
            'settings' => Plugin::getInstance()->getSettings()
        ]);
    }

}