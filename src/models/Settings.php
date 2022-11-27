<?php

namespace wsydney76\contentoverview\models;

use craft\base\Model;
use craft\elements\Asset;
use wsydney76\contentoverview\events\DefineUserSettingEvent;
use wsydney76\contentoverview\services\ContentOverviewService;


class Settings extends Model
{

    public const EVENT_DEFINE_USER_SETTING = 'eventDefineUserSetting';

    // see read me for doc

    public string $customTemplatePath = '_contentoverview';
    public string $defaultLayout = 'list';
    public string $defaultIcon = '@appicons/newspaper.svg';
    public string $defaultPage = 'default';
    public bool $enableSlideoutEditor = true;
    public bool $enableWidgets = true;
    public ?Asset $fallbackImage = null;
    public array $iconSize = ['width' => '20px', 'height' => '20px'];
    public array $layoutSizes = [
        'cards' => 'card',
        'cardlets' => 'large'
    ];
    // 'min,max' 1fr = fill up grid row
    public array $layoutWidth = [
        'tiny' => '10rem,1fr',
        'small' => '16rem,1fr',
        'medium' => '24rem,1fr',
        'large' => '36rem,1fr',
        'card' => '280px,450px' // don't let cards exceed the image width
    ];
    public bool $loadSectionsAsync = false;
    public string $linkTarget = '_blank';
    public array $pages = [];
    public string $pluginTitle = 'Content Overview';
    public array|string|null $purifierConfig = null;
    public bool $replaceDashboard = false;
    public bool $showLoadingIndicator = false;
    public string $showPages = 'nav';
    public array $transforms = [
        'list' => ['width' => 50, 'height' => 50, 'format' => 'webp'],
        'cardlets' => ['width' => 150, 'height' => 150, 'format' => 'webp'],
        'cards' => ['width' => 450, 'height' => 225, 'format' => 'webp'],
        'line' => null, // no image in line layout
        'table' => ['width' => 60, 'height' => 30, 'format' => 'webp']
    ];
    public string $widgetText = 'Get a quick overview of your content';


    public string $serviceClass = ContentOverviewService::class;
    public string $pageClass = Page::class;
    public string $tabClass = Tab::class;
    public string $columnClass = Column::class;
    public string $sectionClass = Section::class;
    public string $actionClass = Action::class;
    public string $filterClass = Filter::class;
    public string $tableSectionClass = TableSection::class;
    public string $tableColumnClass = TableColumn::class;

    /**
     * Get settings with modifications by user events
     *
     * @param $key
     * @return mixed
     */
    public function getUserSetting($key): mixed
    {
        $setting = $this->$key;

        if ($this->hasEventHandlers(self::EVENT_DEFINE_USER_SETTING)) {
            $event = new DefineUserSettingEvent([
                'key' => $key,
                'value' => $setting
            ]);
            $this->trigger(self::EVENT_DEFINE_USER_SETTING, $event);

            $setting = $event->value;
        }

        return $setting;
    }

}