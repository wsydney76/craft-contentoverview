<?php

namespace wsydney76\contentoverview\models;

class CustomSection extends BaseSection
{
    public string $handle;
    public string $customTemplate;
    public array $settings = [];

    public string $sectionTemplate = 'partials/section_custom.twig';


    /**
     * Sets a handle so that the section can be identified in templates
     *
     * @param string $customTemplate
     * @return $this
     */
    public function customTemplate(string $customTemplate): self
    {
        $this->customTemplate = $customTemplate;
        return $this;
    }

    /**
     * Sets a handle for use in custom stuff.
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
     * Optional settings
     *
     * @param array $settings
     * @return $this
     */
    public function settings(array $settings): self
    {
        $this->settings = $settings;
        return $this;
    }
}