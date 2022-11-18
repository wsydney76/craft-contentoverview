<?php

namespace wsydney76\contentoverview\models;

use craft\base\Model;

class BaseSection extends Model
{
    public ?string $heading = '';
    public ?string $linkToPage = '';

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
}