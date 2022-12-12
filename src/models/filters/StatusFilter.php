<?php

namespace wsydney76\contentoverview\models\filters;

use craft\elements\db\ElementQueryInterface;
use wsydney76\contentoverview\models\Filter;
use wsydney76\contentoverview\models\Section;
use wsydney76\contentoverview\Plugin;
use function collect;

class StatusFilter extends Filter
{
    public string $filterType = 'status';


    /**
     * Set options from plugin config
     *
     * @return void
     */
    public function init(): void
    {
        $this->options = collect(Plugin::getInstance()->getSettings()->statusFilterOptions);
    }

    /**
     * Return label, default = 'Status'
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label ?: ' Status';
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
        // format key:value<,key:value>...
        foreach (explode(',', $filter['value']) as $filterValue) {
            $segments = explode(':', $filterValue);
            $key = $segments[0];
            $sectionConfig->$key = $segments[1];
        }
    }
}