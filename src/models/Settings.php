<?php

namespace wsydney76\contentoverview\models;

use Craft;
use craft\base\Model;
use Illuminate\Support\Collection;
use wsydney76\contentoverview\events\DefinePagesEvent;
use wsydney76\contentoverview\events\DefineUserSettingEvent;
use wsydney76\contentoverview\Plugin;
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
    public array $iconSize = ['width' => '20px', 'height' => '20px'];
    public string $customTemplatePath = '_contentoverview';
    public array $transforms = [
        'list' => ['width' => 50, 'height' => 50, 'format' => 'webp'],
        'cardlets' => ['width' => 150, 'height' => 150, 'format' => 'webp'],
        'cards' => ['width' => 400, 'height' => 200, 'format' => 'webp'],
        'line' => null // no image in line layout
    ];
    public string $useCSS = 'all';


    protected array $_tabs = [];

    public string $serviceClass = ContentOverviewService::class;
    public string $pageClass = Page::class;
    public string $tabClass = Tab::class;
    public string $columnClass = Column::class;
    public string $sectionClass = Section::class;
    public string $actionClass = Action::class;
    public string $filterClass = Filter::class;

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