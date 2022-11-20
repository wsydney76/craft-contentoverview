<?php

namespace wsydney76\contentoverview\services;

use Craft;
use craft\base\Component;
use wsydney76\contentoverview\models\Action;
use wsydney76\contentoverview\models\Column;
use wsydney76\contentoverview\models\CustomSection;
use wsydney76\contentoverview\models\Page;
use wsydney76\contentoverview\models\Section;
use wsydney76\contentoverview\models\Tab;
use wsydney76\contentoverview\models\WidgetSection;
use wsydney76\contentoverview\Plugin;

class ContentOverviewService extends Component
{


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
    public function createTab(string $label, array $columns): Tab
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
    public function createSection(string $className = null): Section
    {
        return Craft::createObject($className ?? Plugin::getInstance()->getSettings()->sectionClass);
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

}