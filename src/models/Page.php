<?php

namespace wsydney76\contentoverview\models;

use Craft;
use Illuminate\Support\Collection;
use wsydney76\contentoverview\events\DefineTabsEvent;
use wsydney76\contentoverview\Plugin;
use function collect;

class Page extends BaseModel
{

    public const EVENT_DEFINE_TABS = 'eventDefineTabs';

    public array $blocks = [];
    public string $heading = '';
    public string $icon = '';
    public string $label = 'Untitled Page';
    public string $pageKey;
    public ?string $url = null;

    // makes it easier to distinguish pages and sidebar headings
    public bool $isPageGroup = false;
    

    private array|Collection $_tabs = [];
    
    public function blocks(array $blocks): self
    {
        $this->blocks = $blocks;
        return $this;
    }
    
    public function group(array|string $group): self
    {
        $this->group = $group;
        return $this;
    }
    
    public function heading(string $heading): self
    {
        $this->heading = $heading;
        return $this;
    }
    
    public function icon(string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }
    
    public function label(string $label): self
    {
        $this->label = $label;
        return $this;
    }
    
    public function pageKey(string $pageKey): self
    {
        $this->pageKey = $pageKey;
        return $this;
    }
    
    public function url(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Returns an array of Tab models for this page
     *
     * @return Collection<Tab>
     */
    public function getTabs(): Collection
    {
        // Do not read a file multiple times. (TODO: really needed?)
        if (!$this->_tabs) {
            $config = Craft::$app->config->getConfigFromFile("contentoverview/$this->pageKey");
            if ($config) {
                $this->_tabs = $this->_getTabsFromConfig($config);
            }
        }

        $tabs = collect($this->_tabs);

        if ($this->hasEventHandlers(self::EVENT_DEFINE_TABS)) {
            $event = new DefineTabsEvent([
                'user' => Craft::$app->user->identity,
                'page' => $this,
                'tabs' => $tabs
            ]);

            $this->trigger(self::EVENT_DEFINE_TABS, $event);

            $tabs = $event->tabs;
        }

        return $this->filterForCurrentUser($tabs);
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

    /**
     * Get Tab Config by Tab ID
     *
     * @param $tabId
     * @return array
     */
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

    protected function _getTabsFromConfig(array $config)
    {

        if (!empty($config['columns'])) {
            return [
                Plugin::getInstance()->contentoverview->createTab('Dummy',
                    $config['columns']
                )
            ];
        }

        if (!empty($config['sections'])) {
            $co = Plugin::getInstance()->contentoverview;
            return [
                $co->createTab('Dummy', [
                        $co->createColumn(12, $config['sections'])
                    ]
                )
            ];
        }

        return $config['tabs'];
    }
}