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

    public function init(): void
    {
        $this->options = collect(Plugin::getInstance()->getSettings()->statusFilterOptions);
    }

    public function getLabel(): string
    {
        return $this->label ?: ' Status';
    }

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