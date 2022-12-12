<?php

namespace wsydney76\contentoverview\models\filters;

use craft\elements\db\ElementQueryInterface;
use craft\helpers\ElementHelper;
use wsydney76\contentoverview\models\Section;
use function collect;

class OptionsFilter extends BaseFieldFilter
{
    public string $filterType = 'optionsField';

    /**
     * Set options from options field
     */
    public function init(): void
    {
        $this->options = collect($this->field->options)
            // Exclude empty option
            ->filter(fn($option) => $option['value'] !== '');
    }


    /**
     * Modify query
     *
     * @param Section $sectionConfig
     * @param array $filter
     * @param ElementQueryInterface $query
     * @return void
     */
    public function modifyQuery(Section $sectionConfig, array $filter, ElementQueryInterface $query)
    {
        $columnName = ElementHelper::fieldColumnFromField($this->field);

        $query->andWhere([$columnName => $filter['value']]);
    }

}