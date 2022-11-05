<?php

namespace wsydney76\contentoverview\models;

use craft\base\Model;

class Tab extends Model
{
    public string $label = '';
    public string $id = '';
    public array $columns = [];
    public string $scope = 'all';

    public function label(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function id(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function columns(array $columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    public function scope(string $scope): self
    {
        $this->scope = $scope;
        return $this;
    }

}