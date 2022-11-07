<?php

namespace wsydney76\contentoverview\models;

use craft\base\Model;
use craft\helpers\StringHelper;

class Tab extends Model
{
    public string $label = '';
    public array $columns = [];

    public function label(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function columns(array $columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    public function getId()
    {
        return StringHelper::toKebabCase($this->label);
    }

}