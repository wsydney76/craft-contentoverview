<?php

namespace wsydney76\contentoverview\models;

use Craft;
use craft\helpers\StringHelper;
use Illuminate\Support\Collection;
use wsydney76\contentoverview\events\DefineColumnsEvent;

class Tab extends BaseModel
{
    public const EVENT_DEFINE_COLUMNS = 'eventDefineColumns';

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

    public function getColumns(): Collection
    {
        $columns = collect($this->columns);

        if ($this->hasEventHandlers(self::EVENT_DEFINE_COLUMNS)) {
            $event = new DefineColumnsEvent([
                'user' => Craft::$app->user->identity,
                'tab' => $this,
                'columns' => $columns
            ]);

            $this->trigger(self::EVENT_DEFINE_COLUMNS, $event);

            $columns = $event->columns;
        }

        return $columns;
    }

}