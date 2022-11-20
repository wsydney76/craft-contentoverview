<?php

namespace wsydney76\contentoverview\models;

use craft\base\Model;

class BaseModel extends Model
{
    public string $handle = '';

    /**
     * Sets an optional handle for a model.
     *
     * A handle can be used to identify a page/tab/column/section model in event handlers
     *
     * @param string $handle
     * @return $this
     */
    public function handle(string $handle): self
    {
        $this->handle = $handle;
        return $this;
    }
}