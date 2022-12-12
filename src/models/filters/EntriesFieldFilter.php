<?php

namespace wsydney76\contentoverview\models\filters;

use craft\elements\Entry;
use Illuminate\Support\Collection;
use function collect;


/**
 * Class for entries fields filters
 */
class EntriesFieldFilter extends BaseRelationFieldFilter
{
    public string $filterType = 'entriesField';
    public string $elementType = Entry::class;


    /**
     * Gets filter options
     *
     * @return array|Collection
     * @throws \yii\base\InvalidConfigException
     */
    public function getOptions(): array|Collection
    {
        // element selects will query for options on its own
        if ($this->useElementSelect) {
            return collect([]);
        }

        $this->options = $this->_getOptionsForEntryField($this->field);

        return parent::getOptions();
    }


}