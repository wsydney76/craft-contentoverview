<?php

namespace wsydney76\contentoverview\models\filters;

use craft\elements\Entry;
use Illuminate\Support\Collection;

class EntriesFieldFilter extends BaseRelationFieldFilter
{
    public string $filterType = 'entriesField';
    public string $elementType = Entry::class;

    public function getOptions(): array|Collection
    {
        $this->options = $this->_getOptionsForEntryField($this->field);

        return parent::getOptions();
    }


}