<?php

namespace wsydney76\contentoverview\services;

use Craft;
use craft\base\Component;
use wsydney76\contentoverview\models\Column;
use wsydney76\contentoverview\models\Page;
use wsydney76\contentoverview\models\Section;
use wsydney76\contentoverview\models\Tab;

class ContentOverviewService extends Component
{


    public function createPage(string $pageKey, array $pageConfig): Page
    {
        return new Page([
            'pageKey' => $pageKey,
            'label' => Craft::t('site', $pageConfig['label']),
            'url' => $pageConfig['url'] ?? '',
            'group' => $pageConfig['group'] ?? '',
            'blocks' => $pageConfig['blocks'] ?? []
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
        return new Tab([
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
        return new Column([
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
    public function createSection(string $className = Section::class): Section
    {
        return Craft::createObject($className);
    }

}