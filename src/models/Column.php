<?php

namespace wsydney76\contentoverview\models;

use Craft;
use craft\base\Model;
use wsydney76\contentoverview\events\DefineSectionsEvent;
use yii\base\InvalidConfigException;

class Column extends BaseModel
{
    public const EVENT_DEFINE_SECTIONS = 'eventDefineSections';

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

    public function getSections() {
        $sections = collect($this->sections);

        if ($this->hasEventHandlers(self::EVENT_DEFINE_SECTIONS)) {
            $event = new DefineSectionsEvent([
                'user' => Craft::$app->user->identity,
                'column' => $this,
                'sections' => $sections
            ]);

            $this->trigger(self::EVENT_DEFINE_SECTIONS, $event);
            $sections = $event->sections;
        }

        return $sections;
    }
}