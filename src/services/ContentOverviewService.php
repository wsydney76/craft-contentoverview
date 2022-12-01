<?php

namespace wsydney76\contentoverview\services;

use Craft;
use craft\base\Component;
use Illuminate\Support\Collection;
use wsydney76\contentoverview\events\DefinePagesEvent;
use wsydney76\contentoverview\models\Action;
use wsydney76\contentoverview\models\Column;
use wsydney76\contentoverview\models\CustomSection;
use wsydney76\contentoverview\models\Filter;
use wsydney76\contentoverview\models\Page;
use wsydney76\contentoverview\models\Section;
use wsydney76\contentoverview\models\Tab;
use wsydney76\contentoverview\models\TableColumn;
use wsydney76\contentoverview\models\TableSection;
use wsydney76\contentoverview\models\WidgetSection;
use wsydney76\contentoverview\Plugin;
use yii\base\InvalidConfigException;
use yii\web\ForbiddenHttpException;
use function collect;

class ContentOverviewService extends Component
{

    public const EVENT_DEFINE_PAGES = 'eventDefinePages';

    /**
     * @param string $pageKey
     * @param array $pageConfig
     * @return Page
     * @throws \yii\base\InvalidConfigException
     */
    public function createPage(string $pageKey, array $pageConfig): Page
    {
        return Craft::createObject([
            'class' => Plugin::getInstance()->getSettings()->pageClass,
            'pageKey' => $pageKey,
            'label' => Craft::t('site', $pageConfig['label'] ?? ''),
            'heading' => $pageConfig['heading'] ?? '',
            'url' => $pageConfig['url'] ?? '',
            'group' => $pageConfig['group'] ?? '',
            'blocks' => $pageConfig['blocks'] ?? [],
            'icon' => $pageConfig['icon'] ?? '',
            'handle' => $pageConfig['handle'] ?? ''
        ]);
    }

    /**
     * Create a Tab model
     *
     * @param string $label Tab label, will also be used as kebap formatted id
     * @param array $columns Array of column models
     * @return Tab
     */
    public function createTab(string $label, array $columns = []): Tab
    {
        return Craft::createObject([
            'class' => Plugin::getInstance()->getSettings()->tabClass,
            'label' => $label,
            'columns' => $columns,
        ]);
    }

    /**
     * Create a Column model
     *
     * @param int $width Number of columns 1-12
     * @param array $sections Array of section models
     * @return Column
     */
    public function createColumn(int $width = 12, array $sections = []): Column
    {
        return Craft::createObject([
            'class' => Plugin::getInstance()->getSettings()->columnClass,
            'width' => $width,
            'sections' => $sections
        ]);
    }

    /**
     * Create a Section model
     *
     * @param string $className Class name of a class inherited from Section
     * @return Section
     * @throws \yii\base\InvalidConfigException
     */
    public function createSection(string $className = null, Section|array $config = null): Section
    {
        /** @var Section $section */
        $section = Craft::createObject($className ?? Plugin::getInstance()->getSettings()->sectionClass);
        if ($config) {
            if ($config instanceof Section) {
                $section->setAttributes($config->getAttributes(), false);
            } else {
                $section->setAttributes($config, false);
            }
        }
        return $section;
    }

    /**
     * Create a Custom Section model
     *
     * @param string $className Class name of a class inherited from Section
     * @return Section
     * @throws \yii\base\InvalidConfigException
     */
    public function createCustomSection(): CustomSection
    {
        return Craft::createObject(CustomSection::class);
    }

    /**
     * Create a Widget Section model
     *
     * @return Section
     * @throws \yii\base\InvalidConfigException
     */
    public function createWidgetSection(): WidgetSection
    {
        return Craft::createObject(WidgetSection::class);
    }

    public function createAction(string $className = null): Action
    {
        return Craft::createObject($className ?? Plugin::getInstance()->getSettings()->actionClass);
    }

    public function createFilter(string $type, string $handle = ''): Filter
    {
        return Craft::createObject([
            'class' => Plugin::getInstance()->getSettings()->filterClass,
            'type' => $type,
            'handle' => $handle
        ]);
    }

    public function createTableSection(string $heading, array $columns): TableSection
    {
        return Craft::createObject([
            'class' => Plugin::getInstance()->getSettings()->tableSectionClass,
            'heading' => $heading,
            'columns' => $columns
        ]);
    }

    public function createTableColumn(string $type = 'custom'): TableColumn
    {
        return Craft::createObject([
            'class' => Plugin::getInstance()->getSettings()->tableColumnClass,
            'type' => $type
        ]);
    }

    /**
     * Returns a collection of page configs available for the current user
     *
     * @return Collection
     */
    public function getPages($isSidebar = false): Collection
    {
        $settings = Plugin::getInstance()->getSettings();
        $pages = $settings->pages;
        if (!$pages) {
            // create a single page for use in list widgets
            $pages = [
                $settings->defaultPage => [
                    'label' => $settings->pluginTitle,
                    'url' => 'contentoverview'
                ]
            ];
        }

        // Drop pages if restricted to a user group
        $currentUser = Craft::$app->user->identity;
        $pages = collect($pages)
            ->filter(function($page) use ($currentUser) {
                return $currentUser->admin || !isset($page['group']) || $currentUser->isInGroup($page['group']);
            });

        // Drop group heading pseudo pages if links not displayed in sidebar block
        if (!$isSidebar) {
            $pages = $pages->filter(function($page) {
                return !isset($page['heading']);
            });
        }

        // Create Page models
        $pages = $pages->map(fn($page, $key) => $this->createPage($key, $page));

        // Give custom modules the chance to modify pages
        if ($this->hasEventHandlers(self::EVENT_DEFINE_PAGES)) {
            $event = new DefinePagesEvent([
                'user' => Craft::$app->user->identity,
                'pages' => $pages
            ]);

            $this->trigger(self::EVENT_DEFINE_PAGES, $event);

            $pages = $event->pages;
        }

        return $pages;
    }

    public function getSectionByPath(string $sectionPath): Section
    {
        $segments = explode('-', $sectionPath);

        $config = Craft::$app->config->getConfigFromFile("contentoverview/{$segments[0]}");

        if (!$config) {
            throw new InvalidConfigException("$sectionPath is an invalid path.");
        }

        $page = Plugin::getInstance()->contentoverview->createPage($segments[0], $config);

        /** @var Section $section */
        $section = $page->getTabs()[$segments[1]]->getColumns()[$segments[2]]->getSections()[$segments[3]];

        if ($section->section && !$section->getPermittedSections('viewentries')) {
            throw new ForbiddenHttpException();
        }

        return $section;
    }

}