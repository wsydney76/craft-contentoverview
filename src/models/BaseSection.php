<?php

namespace wsydney76\contentoverview\models;

class BaseSection extends BaseModel
{

    public ?string $heading = '';
    public array|string $help = '';
    public ?string $linkToPage = '';
    public bool $showRefreshButton = false;

    // The partial that will be called to render this section
    public string $sectionTemplate = 'partials/section.twig';

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
     * Sets a help text. String or array with keys 'text' or 'template', 'type' (optional, tip/warning)
     *
     * @param string $help
     * @return $this
     */
    public function help(array|string $help): self
    {
        $this->help = $help;
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