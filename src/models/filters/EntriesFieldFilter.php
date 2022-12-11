<?php

namespace wsydney76\contentoverview\models\filters;

use Craft;
use craft\base\Field;
use craft\elements\Entry;
use Illuminate\Support\Collection;
use function explode;

class EntriesFieldFilter extends BaseRelationFieldFilter
{
    public string $filterType = 'entriesField';

    public function getOptions(): array|Collection
    {
        $this->options = $this->_getOptionsForEntryField($this->field);

        return parent::getOptions();
    }


}