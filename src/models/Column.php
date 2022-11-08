<?php

namespace wsydney76\contentoverview\models;

use craft\base\Model;
use yii\base\InvalidConfigException;

class Column extends Model
{
    public int $width = 12;
    public array $sections;

    /**
     * Width of the column within a 12 columns grid
     *
     * @param int $width
     * @return $this
     * @throws InvalidConfigException
     */
    public function width(int $width): self
    {
        if ($width < 1 || $width > 12)  {
            throw new  InvalidConfigException("$width is not a valid width config.");
        }
        $this->width = $width;
        return $this;
    }


    /**
     * Sets the sections within the column
     *
     * @param array $sections
     * @return $this
     */
    public function sections(array $sections): self
    {
        $this->sections = $sections;
        return $this;
    }
}