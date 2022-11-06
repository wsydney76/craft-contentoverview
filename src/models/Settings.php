<?php

namespace wsydney76\contentoverview\models;

use Craft;
use craft\base\Model;
use Illuminate\Support\Collection;

class Settings extends Model
{
    public $pluginTitle = 'Content Overview';
    public $enableNav = true;
    public $enableWidgets = true;
    public $widgetText = 'Get a quick overview of your content';
    public $linkTarget = '_blank';
    public $defaultLayout = 'list';
    public $transforms = [
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

    public function getTabs($scope = 'all'): Collection
    {

        if (!$this->_tabs) {
            $config = Craft::$app->config->getConfigFromFile('contentoverview_tabs');
            if (!$config) {
                return collect([]);
            }
            $this->_tabs = $config['tabs'];
        }

        $tabs = collect($this->_tabs);

        if ($scope === 'all') {
            return $tabs;
        }

        return $tabs->filter(function($tab) use ($scope) {
            return $tab->scope === 'all' || $tab->scope === $scope;
        });


    }

    public function getTabConfig($tabId): ?Tab
    {
        return collect($this->getTabs())->firstWhere('id', $tabId);
    }
}