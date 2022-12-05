<?php

namespace wsydney76\contentoverview\models;

use craft\base\Widget;

class WidgetSection extends BaseSection
{

    public Widget $widget;
    public array $settings = [];

    public string $sectionTemplate = 'partials/section_widget.twig';


    /**
     * Widget settings that are passed to the constructor.
     *
     * @param array $settings
     * @return $this
     */
    public function settings(array $settings): self
    {
        $this->settings = $settings;
        return $this;
    }

    /**
     * The widget instance
     *
     * @param Widget $widget
     * @return $this
     */
    public function widget(Widget $widget): self
    {
        $this->widget = $widget;
        return $this;
    }
}