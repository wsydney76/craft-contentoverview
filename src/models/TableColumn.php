<?php

namespace wsydney76\contentoverview\models;

class TableColumn extends BaseModel
{
    public string $type = 'custom';
    public string $label = '';
    public string $value = '';
    public string $template = '';
    public string $align = 'left';

    /**
     * Type of column. Values != 'custom' are used for predefined columns (title, image etc.)
     *
     * @param string $type
     * @return $this
     */
    public function type(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Column label (heading)
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
     * Value of column as object template.
     *
     * @param string $value
     * @return $this
     */
    public function value(string $value): self
    {
        $this->value = $value;
        return $this;
    }


    /**
     * Path to a template that renders the column content
     *
     * @param string $template
     * @return $this
     */
    public function template(string $template): self
    {
        $this->template = $template;
        return $this;
    }

    /**
     * How to align the columns content left|right
     *
     * @param string $align
     * @return $this
     */
    public function align(string $align): self
    {
        $this->align = $align;
        return $this;
    }

}