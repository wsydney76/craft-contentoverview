<?php

namespace wsydney76\contentoverview\models;

use craft\base\Model;
use craft\base\Widget;

class WidgetSection extends BaseSection
{

    public Widget $widget;
    public array $settings = [];

    public string $sectionTemplate = 'partials/section_widget.twig';

    public function handle(string $handle): self
    {
        $this->handle = $handle;
        return $this;
    }
    
    public function settings(array $settings): self
    {
        $this->settings = $settings;
        return $this;
    }

    public function widget(Widget $widget): self
    {
        $this->widget = $widget;
        return $this;
    }
}