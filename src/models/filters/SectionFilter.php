<?php

namespace wsydney76\contentoverview\models\filters;

use Craft;
use craft\elements\db\ElementQueryInterface;
use wsydney76\contentoverview\models\Filter;
use wsydney76\contentoverview\models\Section;
use wsydney76\contentoverview\Plugin;
use function collect;
use function strtoupper;
use function ucfirst;

class SectionFilter extends Filter
{
    public string $filterType = 'section';


    /**
     * Set options from plugin config
     *
     * @return void
     */
    public function init(): void
    {
        $this->options = collect(Craft::$app->getEntries()->getAllSections())
            ->filter(fn($section) => $section->type !== 'single')
            ->map(fn($section) => [
                'label' => $section->name . ' (' . Craft::t('app', ucfirst($section->type)) . ')',
                'value' => $section->handle
            ])
        ;
    }

    /**
     * Return label, default = 'Status'
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label ?: Craft::t('app', 'Section');
    }


    /**
     * Modify sectionConfig settings, that will then be respected when building the query
     *
     * @param Section $sectionConfig
     * @param array $filter
     * @param ElementQueryInterface $query
     * @return void
     */
    public function modifyQuery(Section $sectionConfig, array $filter, ElementQueryInterface $query)
    {
        $query->section($filter['value']);

    }
}