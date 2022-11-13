<?php

namespace wsydney76\contentoverview\models;

use Craft;
use craft\base\Model;
use Illuminate\Support\Collection;


class Settings extends Model
{
    // see read me for doc
    public string $pluginTitle   = 'Content Overview';
    public array $pages = [];
    public bool $enableNav = true;
    public bool $enableWidgets = true;
    public string $widgetText = 'Get a quick overview of your content';
    public string $linkTarget = '_blank';
    public string $defaultLayout = 'list';
    public string $defaultPage = 'default';
    public string $defaultIcon = '@appicons/newspaper.svg';
    public array $iconSize = ['width' => '20px', 'height' => '20px'];
    public string $customTemplatePath = '_contentoverview';
    public array $transforms = [
        'list' => ['width' => 50, 'height' => 50, 'format' => 'webp'],
        'cardlets' => ['width' => 150, 'height' => 150, 'format' => 'webp'],
        'cards' => ['width' => 400, 'height' => 200, 'format' => 'webp'],
        'line' => null // no image in line layout
    ];
    public string $sectionClass = Section::class;

    protected array $_tabs = [];

    public function rules(): array
    {
        return [
            ['pluginTitle', 'string', 'max' => 30]
        ];
    }

    /**
     * Returns a collection of page configs available for the current user
     *
     * @return Collection
     */
    public function getPages(): Collection
    {
        $pages = $this->pages;
        if (!$pages) {
            // create a single page for use in list widgets
            $pages = [
                $this->defaultPage => [
                    'label' => $this->pluginTitle,
                    'url' => 'contentoverview'
                ]
            ];
        }

        return collect($pages)->filter(function($page) {
            if (!isset($page['group'])) {
                return true;
            }
            $currentUser = Craft::$app->user->identity;
            return $currentUser->admin || $currentUser->isInGroup($page['group']);
        });
    }

    /**
     * Returns an array of Tab models for a given page
     *
     * @param string $page
     * @return Collection
     */
    public function getTabs(string $page = 'default'): Collection
    {
        $config = Craft::$app->config->getConfigFromFile("contentoverview/$page");
        if (!$config) {
            return collect([]);
        }
        return collect($config['tabs']);
    }


    /**
     * Returns a tab model/tabIndex for given page/tabId
     *
     * @param string $page
     * @param string $tabId
     * @return Tab|null
     */
    public function getTabConfig(string $page, string $tabId): array
    {
        $i = 0;
        $selectedTab = null;
        foreach ($this->getTabs($page) as $tab) {
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


    /**
     * @param string $page
     * @return string
     */
    public function getPageLabel(string $page): string
    {
        return $this->pages[$page]['label'] ?? '';
    }
}