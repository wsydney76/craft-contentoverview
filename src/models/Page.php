<?php

namespace wsydney76\contentoverview\models;

use Craft;
use craft\base\Model;
use Illuminate\Support\Collection;
use function collect;

class Page extends Model
{
    public string $pageKey;
    public string $label;
    public string $url;
    public string $group = '';
    public array $blocks = [];

    private array $_tabs = [];

    /**
     * Returns an array of Tab models for this page
     *
     * @return Collection
     */
    public function getTabs(): Collection
    {
        if (!$this->_tabs) {
            $config = Craft::$app->config->getConfigFromFile("contentoverview/$this->pageKey");
            if ($config) {
                $this->_tabs = $config['tabs'];
            }
        }

        return collect($this->_tabs);
    }

    /**
     * Return tab config as required by Crafts page template
     *
     * @return Collection
     */
    public function getCpTabs(): Collection
    {
        return $this->getTabs()->map(fn($tab) => [
            'label' => Craft::t('site', $tab->label),
            'url' => "#{$tab->getId()}"
        ]);
    }

    public function getTabConfig($tabId)
    {
        $i = 0;
        $selectedTab = null;
        foreach ($this->getTabs() as $tab) {
            if ($tab->getId() === $tabId) {
                $selectedTab = $tab;
                break;
            }
            $i++;
        }

        return [
            'tab' => $selectedTab,
            'tabIndex' => $i
        ];

    }

}