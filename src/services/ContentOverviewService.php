<?php

namespace wsydney76\contentoverview\services;

use Craft;
use craft\fields\BaseOptionsField;
use craft\fields\Entries;
use craft\fields\Matrix;
use craft\fields\Users;
use Illuminate\Support\Collection;
use wsydney76\contentoverview\events\DefinePagesEvent;
use wsydney76\contentoverview\models\Action;
use wsydney76\contentoverview\models\BaseModel;
use wsydney76\contentoverview\models\Column;
use wsydney76\contentoverview\models\CustomSection;
use wsydney76\contentoverview\models\Filter;
use wsydney76\contentoverview\models\filters\BaseFieldFilter;
use wsydney76\contentoverview\models\filters\CustomFilter;
use wsydney76\contentoverview\models\Page;
use wsydney76\contentoverview\models\Section;
use wsydney76\contentoverview\models\Settings;
use wsydney76\contentoverview\models\Tab;
use wsydney76\contentoverview\models\TableColumn;
use wsydney76\contentoverview\models\TableSection;
use wsydney76\contentoverview\models\WidgetSection;
use wsydney76\contentoverview\Plugin;
use yii\base\InvalidConfigException;
use yii\web\ForbiddenHttpException;
use function collect;
use function explode;

class ContentOverviewService extends BaseModel
{

    public const EVENT_DEFINE_PAGES = 'eventDefinePages';

    protected ?Collection $_pages = null;


    /**
     * Create a page model instance
     *
     * @param string $pageKey
     * @return Page
     * @throws InvalidConfigException
     */
    public function createPage(string $pageKey): Page
    {
        return Craft::createObject([
            'class' => Plugin::getInstance()->getSettings()->pageClass,
            'pageKey' => $pageKey,
            'url' => "contentoverview/$pageKey"
        ]);
    }

    /**
     * Create a page group (i.e. a heading for the sidebar cp twig block)
     *
     *
     * @param string $pageKey
     * @return Page
     * @throws InvalidConfigException
     */
    public function createPageGroup(string $pageKey = ''): Page
    {
        return Craft::createObject([
            'class' => Plugin::getInstance()->getSettings()->pageClass,
            'pageKey' => $pageKey,
            'isPageGroup' => true
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

    /**
     * Create an action model
     *
     * @param string|null $className
     * @return Action
     * @throws InvalidConfigException
     */
    public function createAction(string $className = null): Action
    {
        return Craft::createObject($className ?? Plugin::getInstance()->getSettings()->actionClass);
    }

    /**
     * Create a filter model
     *
     * @param string $type
     * @param string $handle
     * @return Filter
     * @throws InvalidConfigException
     */
    public function createFilter(string $type, string $handle = ''): Filter
    {
        switch ($type) {
            case 'status':
            {
                return $this->createStatusFilter();
            }

            case 'custom':
            {
                $class = $this->createCustomFilter(Plugin::getInstance()->getSettings()->customFilterClass);
                $class->handle($handle);
                return $class;
            }

            default:
            {
                return $this->createFieldFilter($handle);
            }
        }

    }

    public function createStatusFilter()
    {
        return Craft::createObject([
            'class' => Plugin::getInstance()->getSettings()->statusFilterClass,
            'handle' => 'status'
        ]);
    }

    public function createCustomFilter(string $className): CustomFilter {
        return Craft::createObject([
            'class' => $className,
        ]);
    }

    public function createFieldFilter(string $handle): BaseFieldFilter {
        $segments = explode('.', $handle);
        $fieldHandle = $segments[0];

        $field = Craft::$app->fields->getFieldByHandle($fieldHandle);

        if (!$field) {
            throw new InvalidConfigException("Invalid field handle $fieldHandle");
        }

        if ($field instanceof Users) {
            return Craft::createObject([
                'class' => Plugin::getInstance()->getSettings()->usersFieldFilterClass,
                'handle' => $handle,
                'field' => $field
            ]);
        }

        if ($field instanceof Entries) {
            return Craft::createObject([
                'class' => Plugin::getInstance()->getSettings()->entriesFieldFilterClass,
                'handle' => $handle,
                'field' => $field
            ]);
        }

        if ($field instanceof Matrix) {
            return Craft::createObject([
                'class' => Plugin::getInstance()->getSettings()->matrixFieldFilterClass,
                'handle' => $handle,
                'field' => $field
            ]);
        }

        if ($field instanceof BaseOptionsField) {
            return Craft::createObject([
                'class' => Plugin::getInstance()->getSettings()->optionsFieldFilterClass,
                'handle' => $handle,
                'field' => $field
            ]);
        }
    }

    /**
     * Create a Table Section model
     *
     * @param string $heading
     * @param array<TableColumn> $columns
     * @return TableSection
     * @throws InvalidConfigException
     */
    public function createTableSection(string $heading, array $columns): TableSection
    {
        return Craft::createObject([
            'class' => Plugin::getInstance()->getSettings()->tableSectionClass,
            'heading' => $heading,
            'columns' => $columns
        ]);
    }

    /**
     * Create a table column model
     *
     * @param string $type
     * @return TableColumn
     * @throws InvalidConfigException
     */
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
    public function getPages(): Collection
    {

        if (!$this->_pages) {

            /** @var Settings $settings */
            $settings = Plugin::getInstance()->getSettings();

            $pages = collect(Craft::$app->config->getConfigFromFile('contentoverview/pages'));


            // Create the default page if no pages are configured
            if ($pages->count() === 0) {
                $pages->push(
                    $this->createPage($settings->defaultPage)
                        ->label($settings->pluginTitle)
                );
            }

            // Give custom modules the chance to modify pages
            if ($this->hasEventHandlers(self::EVENT_DEFINE_PAGES)) {
                $event = new DefinePagesEvent([
                    'user' => Craft::$app->user->identity,
                    'pages' => $pages
                ]);

                $this->trigger(self::EVENT_DEFINE_PAGES, $event);

                $pages = $event->pages;
            }

            $this->_pages = $pages;
        }

        return $this->filterForCurrentUser($this->_pages);
    }

    public function getPageByKey(string $pageKey): Page
    {
        $pages = $this->getPages();

        if ($pageKey === '') {
            // Get the first page that has a url
            return $pages->firstWhere(fn(Page $page) => $page->url);
        }

        return $pages->firstWhere('pageKey', $pageKey);
    }

    public function getSectionByPath(string $sectionPath): Section
    {
        $segments = explode('-', $sectionPath);


        // We do not need a fully initialized page here, just the getTabs() method.
        $page = Plugin::getInstance()->contentoverview->createPage($segments[0]);

        /** @var Section $section */
        $section = $page->getTabs()[$segments[1]]->getColumns()[$segments[2]]->getSections()[$segments[3]];

        if ($section->section && !$section->getPermittedSections('viewentries')) {
            throw new ForbiddenHttpException();
        }

        return $section;
    }

}