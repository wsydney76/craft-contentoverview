<?php

namespace wsydney76\contentoverview\models;

use craft\base\Model;
use craft\helpers\ArrayHelper;

class Settings extends Model
{
    public $navLabel = 'Content Overview';
    public $enableNav = true;
    public $enableWidgets = true;
    public $tabs = [];
    public $widgetText = 'Get a quick overview of your content';
    public $linkTarget = '_blank';
    public $defaultLayout = 'list';
    public $transforms = [
        'list' => ['width' => 50, 'height' => 50, 'format' => 'webp'],
        'cardlets' => ['width' => 150, 'height' => 150, 'format' => 'webp'],
        'cards' => ['width' => 400, 'height' => 200, 'format' => 'webp'],
    ];

    public function getTabs($scope = 'all')
    {

        $tabs = collect($this->tabs);

        if ($scope === 'all') {
            return $tabs;
        }

        return $tabs->filter(function($tab) use ($scope) {
            return !isset($tab['scope']) || $tab['scope'] === $scope;
        });


    }

    public function getTabConfig($tabId): ?array
    {
        return ArrayHelper::firstWhere($this->tabs, 'id', $tabId);
    }
}