<?php

namespace wsydney76\contentoverview\models;

use Craft;
use craft\base\Model;
use Illuminate\Support\Collection;
use wsydney76\contentoverview\events\DefinePagesEvent;
use wsydney76\contentoverview\events\DefineUserSettingEvent;
use wsydney76\contentoverview\Plugin;


class Settings extends Model
{
    public const EVENT_DEFINE_PAGES = 'eventDefinePages';
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


    protected array $_tabs = [];

    public string $pageClass = Page::class;
    public string $tabClass = Tab::class;
    public string $columnClass = Column::class;
    public string $sectionClass = Section::class;
    public string $actionClass = Action::class;

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
    public function getPages($isSidebar = false): Collection
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

        $currentUser = Craft::$app->user->identity;

        $pages = collect($pages)
            ->filter(function($page) use ($currentUser) {
                return $currentUser->admin || !isset($page['group']) || $currentUser->isInGroup($page['group']);
            });

        if (!$isSidebar) {
            $pages = $pages->filter(function($page) {
                return !isset($page['heading']);
            });
        }

        $service = Plugin::getInstance()->contentoverview;
        $pages = $pages->map(fn($page, $key) => $service->createPage($key, $page));

        if ($this->hasEventHandlers(self::EVENT_DEFINE_PAGES)) {
            $event = new DefinePagesEvent([
                'pages' => $pages
            ]);

            $this->trigger(self::EVENT_DEFINE_PAGES, $event);

            $pages = $event->pages;
        }

        return $pages;
    }

    public function getUserSetting($key)
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