<?php

namespace wsydney76\contentoverview\models\filters;

use craft\base\Field;
use wsydney76\contentoverview\models\Filter;


class BaseFieldFilter extends Filter
{
    public Field $field;

    public function getLabel(): string
    {
        return $this->label ?: $this->field->name;
    }
}