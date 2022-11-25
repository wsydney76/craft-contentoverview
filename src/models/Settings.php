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
    public string $pluginTitle = 'Content Overview';
    public bool $replaceDashboard = false;
    public array $pages = [];
    public string $showPages = 'nav';
    public bool $enableWidgets = true;
    public string $widgetText = 'Get a quick overview of your content';
    public string $linkTarget = '_blank';
    public bool $enableSlideoutEditor = true;
    public string $defaultLayout = 'list';
    public string $defaultPage = 'default';
    public string $defaultIcon = '@appicons/newspaper.svg';
    public ?Asset $fallbackImage = null;
    public array $iconSize = ['width' => '20px', 'height' => '20px'];
    public string $customTemplatePath = '_contentoverview';
    public array $transforms = [
        'list' => ['width' => 50, 'height' => 50, 'format' => 'webp'],
        'cardlets' => ['width' => 150, 'height' => 150, 'format' => 'webp'],
        'cards' => ['width' => 400, 'height' => 200, 'format' => 'webp'],
        'line' => null, // no image in line layout
        'table' => ['width' => 50, 'height' => 50, 'format' => 'webp']
    ];
    public string $useCSS = 'all';
    public array $layoutSizes = [
        'cards' => 'medium',
        'cardlets' => 'large'
    ];
    public array $containerBreakpointColumns = [
        400 => [
            'medium' => 2,
            'small' => 3,
            'tiny' => 4
        ],
        500 => [
            'large' => 2
        ],
        800 => [
            'medium' => 3,
            'small' => 4,
            'tiny' => 6
         ],
        920 => [
            'large' => 3
        ],
        1000 => [
            'medium' => 4,
            'small' => 5,
        ],
        1200 => [
            'medium' => 5,
            'tiny' => 8
        ],
        1400 => [
            'large' => 4,
            'small' => 6
        ],
        1600 => [
            'medium' => 6,
            'large' => 5
        ]

    ];


    protected array $_tabs = [];

    public string $serviceClass = ContentOverviewService::class;
    public string $pageClass = Page::class;
    public string $tabClass = Tab::class;
    public string $columnClass = Column::class;
    public string $sectionClass = Section::class;
    public string $actionClass = Action::class;
    public string $filterClass = Filter::class;
    public string $tableSectionClass = TableSection::class;
    public string $tableColumnClass = TableColumn::class;

    public function rules(): array
    {
        return [
            ['pluginTitle', 'string', 'max' => 30]
        ];
    }


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