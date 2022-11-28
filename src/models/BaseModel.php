<?php

namespace wsydney76\contentoverview\models;

use craft\base\Model;

class BaseModel extends Model
{
    public string $handle = '';
    public array $custom = [];
    public bool $showRefreshButton = false;

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

    /**
     * Array of custom attributes
     *
     * @param array $custom
     * @return $this
     */
    public function custom(array $custom): self
    {
        $this->custom = $custom;
        return $this;
    }

    /**
     * Whether to show a refresh button
     *
     * @param bool $showRefreshButton
     * @return $this
     */
    public function showRefreshButton(bool $showRefreshButton): self
    {
        $this->showRefreshButton = $showRefreshButton;
        return $this;
    }
}