<?php

namespace wsydney76\contentoverview\models;

use Craft;
use craft\elements\db\ElementQueryInterface;
use Illuminate\Support\Collection;
use wsydney76\contentoverview\events\DefineCustomFilterOptionsEvent;
use yii\base\InvalidConfigException;
use function collect;
use function is_array;

class Filter extends BaseModel
{
    public const EVENT_DEFINE_CUSTOM_FILTER_OPTIONS = 'defineCustomFilterOptions';

    public string $label = '';
    public array|Collection $options;
    public string $filterType = '';
    public bool $useSelectize = false;
    public bool $useElementSelect = false;

    /**
     * Set label for select / empty option
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
     * Render filter as selectize input?
     *
     * @param bool $useSelectize
     * @return $this
     */
    public function useSelectize(bool $useSelectize = true): self
    {
        $this->useSelectize = $useSelectize;
        return $this;
    }

    public function useElementSelect(bool $useElementSelect = true): self
    {
        $this->useElementSelect = $useElementSelect;
        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function options(array $options): self
    {
        $this->options = collect($options);
        return $this;
    }

    /**
     * Get select options
     *
     * @return array|Collection
     * @throws InvalidConfigException
     */
    public function getOptions(): array|Collection
    {
        if (is_array($this->options)) {
            $this->options = collect($this->options);
        }

        if ($this->hasEventHandlers(self::EVENT_DEFINE_CUSTOM_FILTER_OPTIONS)) {
            $event = new DefineCustomFilterOptionsEvent([
                'user' => Craft::$app->user->identity,
                'filter' => $this,
                'options' => $this->options
            ]);

            $this->trigger(self::EVENT_DEFINE_CUSTOM_FILTER_OPTIONS, $event);

            $this->options = $event->options;
        }

        return $this->options;
    }

    public function modifyQuery(Section $sectionConfig, array $filter, ElementQueryInterface $query)
    {
        // Implement this!
    }

}