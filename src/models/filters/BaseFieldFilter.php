<?php

namespace wsydney76\contentoverview\models\filters;

use craft\base\Field;
use wsydney76\contentoverview\models\Filter;

/**
 * The class all field filter should extend
 */
class BaseFieldFilter extends Filter
{
    /**
     * Holds the field instance
     *
     * @var Field
     */
    public Field $field;

    /**
     * Get filter label, defaults to field name
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label ?: $this->field->name;
    }
}