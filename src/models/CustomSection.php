<?php

namespace wsydney76\contentoverview\models;

use Craft;
use craft\base\Model;
use function array_map;
use function implode;

class CustomSection extends Model
{
    public string $heading;
    public string $handle;
    public string $linkToPage = '';
    public string $customTemplate;

    // make it easer to detect custom sections, instead of using class names
    public bool $isCustomSection = true;

    /**
     * Heading of the section
     *
     * Will be translated in 'site' category
     *
     * Default: Section name
     *
     * @param string $heading
     * @return $this
     */
    public function heading(string $heading): self
    {
        $this->heading = $heading;
        return $this;
    }

    /**
     * Page key the section heading will be linked to. Can include a tab id as anchor
     * e.g. page2#tab1
     *
     * @param string $linkToPage
     * @return $this
     */
    public function linkToPage(string $linkToPage): self
    {
        $this->linkToPage = $linkToPage;
        return $this;
    }

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

    public function handle(string $handle): self
    {
        $this->handle = $handle;
        return $this;
    }
}