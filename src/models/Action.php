<?php

namespace wsydney76\contentoverview\models;

use craft\elements\Entry;

class Action extends BaseModel
{
    public string $label;
    public string $icon = '';
    public string $cpAction = '';
    public string $jsFunction = '';
    public string $slideoutTemplate = '';
    public string $popupTemplate = '';
    public string $cpUrl = '';
    public string $cpUrlTarget = '_blank';
    public array $extraParams = [];

    /**
     * Action label
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
     * Path to svg file
     *
     * @param string $icon
     * @return $this
     */
    public function icon(string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }


    /**
     * Custom controller action
     *
     * @param string $cpAction
     * @return $this
     */
    public function cpAction(string $cpAction): self
    {
        $this->cpAction = $cpAction;
        return $this;
    }


    /**
     * Custom Javascript function
     * Signature:
     * function myApp_publish_release(label, elementId, draftId, title, sectionPath, sectionPageNo)
     * @param string $jsFunction
     * @return $this
     */
    public function jsFunction(string $jsFunction): self
    {
        $this->jsFunction = $jsFunction;
        return $this;
    }


    /**
     * Custom CP Url
     *
     * @param string $cpUrl
     * @return $this
     */
    public function cpUrl(string $cpUrl): self
    {
        $this->cpUrl = $cpUrl;
        return $this;
    }

    /**
     * Target attribut for cpUrl link
     *
     * @param string $cpUrlTarget
     * @return $this
     */
    public function cpUrlTarget(string $cpUrlTarget): self
    {
        $this->cpUrlTarget = $cpUrlTarget;
        return $this;
    }

    /**
     * Template that will be rendered in a popup (HUD)
     *
     * @param string $popupTemplate
     * @return $this
     */
    public function popupTemplate(string $popupTemplate): self
    {
        $this->popupTemplate = $popupTemplate;
        return $this;
    }

    /**
     * Template that will be rendered in a slideout
     *
     * @param string $slideoutTemplate
     * @return $this
     */
    public function slideoutTemplate(string $slideoutTemplate): self
    {
        $this->slideoutTemplate = $slideoutTemplate;
        return $this;
    }

    /**
     * Set addtional params for action
     *
     * @param array $extraParams
     * @return $this
     */
    public function extraParams(array $extraParams): self
    {
        $this->extraParams = $extraParams;
        return $this;
    }

    /**
     * Returns whether is action is active for an entry.
     *
     * @param Entry $entry
     * @return bool
     */
    public function isActiveForEntry(Entry $entry): bool
    {
        return true;
    }

}