<?php

namespace wsydney76\contentoverview\models;

use Craft;
use craft\base\Model;
use Illuminate\Support\Collection;


class Settings extends Model
{
    public string $pluginTitle = 'Content Overview';
    public array $pages = [];
    public bool $enableNav = true;
    public bool $enableWidgets = true;
    public string $widgetText = 'Get a quick overview of your content';
    public string $linkTarget = '_blank';
    public string $defaultLayout = 'list';
    public string $defaultPage = 'default';
    public array $transforms = [
        'list' => ['width' => 50, 'height' => 50, 'format' => 'webp'],
        'cardlets' => ['width' => 150, 'height' => 150, 'format' => 'webp'],
        'cards' => ['width' => 400, 'height' => 200, 'format' => 'webp'],
    ];
    public string $sectionClass = Section::class;

    protected array $_tabs = [];

    public function rules(): array
    {
        return [
            ['pluginTitle', 'string', 'max' => 30]
        ];
    }

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

    public function getTabs(string $page = 'tabs'): Collection
    {
        $config = Craft::$app->config->getConfigFromFile("contentoverview/$page");
        if (!$config) {
            return collect([]);
        }
        return collect($config['tabs']);
    }

    public function getTabConfig(string $page, string $tabId): ?Tab
    {
        return $this->getTabs($page)->filter(fn($tab) => $tab->getId() === $tabId)->first();
    }

    public function getPageLabel(string $page): string
    {
        return $this->pages[$page]['label'] ?? '';
    }
}