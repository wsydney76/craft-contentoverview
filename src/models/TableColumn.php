<?php

namespace wsydney76\contentoverview\models;

class TableColumn extends BaseModel
{
    public string $type = 'custom';
    public string $label = '';
    public string $value = '';
    public string $template = '';
    public string $align = 'left';
    
    public function type(string $type): self
    {
        $this->type = $type;
        return $this;
    }
    
    public function label(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function value(string $value): self
    {
        $this->value = $value;
        return $this;
    }

    public function template(string $template): self
    {
        $this->template = $template;
        return $this;
    }
    
    public function align(string $align): self
    {
        $this->align = $align;
        return $this;
    }
    
}