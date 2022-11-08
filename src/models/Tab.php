<?php

namespace wsydney76\contentoverview\models;

use craft\base\Model;
use craft\helpers\StringHelper;

class Tab extends Model
{
    public string $label = '';
    public array $columns = [];

    /**
     * Sets label of the tab. Also used for building the tab id.
     *
     * @param string $label
     * @return $this
     */
    public function label(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Sets the columns for this tab
     *
     * @param array $columns
     * @return $this
     */
    public function columns(array $columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * Returns the tab id based on the label
     *
     * @return string
     */
    public function getId()
    {
        return StringHelper::toKebabCase($this->label);
    }

}