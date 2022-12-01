<?php

namespace wsydney76\contentoverview\assets;

use Craft;
use craft\web\AssetBundle;

/**
 * The work plugin does not offer a possibility to load css from outside, so we have to load it here.
 */
class ElementmapPluginAssetBundle extends AssetBundle
{
    public function init()
    {
        $this->sourcePath = Craft::$app->plugins->getPlugin('elementmap')->basePath . '/assets/dist/elementmap.css';
        $this->css = [
            'work.css'
        ];
    }
}